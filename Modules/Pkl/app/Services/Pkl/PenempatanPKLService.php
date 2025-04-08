<?php

namespace Modules\Pkl\Services\Pkl;

use App\Models\Dudi;
use App\Models\Pegawai;
use App\Models\PklRegistration;
use App\Services\DataTableService;
use Illuminate\Database\QueryException;
use Modules\Pkl\Repositories\BasePklRepository;

class PenempatanPKLService
{

    protected $repository;

    public function __construct(BasePklRepository $repository)
    {
        /**
         * Memangil Model yang digunakan di repository
         */
        $this->repository = $repository->setModel(new PklRegistration());
    }

    private function prepareData(array $input)
    {
        $save['dudi_id']        = $input['dudi_id'] ?? null;
        $save['pegawai_id']     = $input['pegawai_id'] ?? null;
        $save['pembina_name']   = $input['pembina_name'] ?? null;
        $save['pembina_jabatan']   = $input['pembina_jabatan'] ?? null;
        $save['pembina_hp']   = $input['pembina_hp'] ?? null;
        return $save;;
    }

    public function store(array $input, $registerId)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $dataToSave = $this->prepareData($input);

            if (!empty($dataToSave['pegawai_id'])) {
                $getPegawai = Pegawai::find($dataToSave['pegawai_id']);
                $dataToSave['guru_name']    = $getPegawai->name;
                $dataToSave['guru_nip']     = $getPegawai->nip;
                $dataToSave['guru_hp']      = $getPegawai->telepon;
            }

            if (!empty($dataToSave['dudi_id'])) {
                $dataToSave['status_pelaksana'] = 'completed';
            } else {
                $dataToSave['status_pelaksana'] = 'pending';
            }

            $response = $this->repository->update($dataToSave, $registerId);
        } catch (QueryException $e) {
            $response['statusCode'] = 400;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function table($request)
    {
        $query = DataTableService::draw('pkl_registrations')
            ->select(['pkl_registrations.*', 'siswas.name', 'siswas.nis', 'siswas.rombel_name', 'siswas.jurusan_id'])
            ->join('siswas', [
                ['siswas.id', '=', 'pkl_registrations.siswa_id'],
            ])
            ->where('status_register', 'completed')
            // ->where('status_pelaksana', $request['status'])
            // ->where('periode_id', $request['priode'])
            // ->where('pkl_registrations.jurusan_id', $request['jurusan'])
            ->where('deleted_at', null);
        // Tambahkan kondisi where jika 'dudi' tidak kosong
        if (!empty($request['status'])) {
            $query->where('status_pelaksana', $request['status']);
        }
        if (!empty($request['priode'])) {
            $query->where('periode_id', $request['priode']);
        }
        if (!empty($request['dudi'])) {
            $query->where('dudi_id', $request['dudi']);
        }

        $query->where('pkl_registrations.jurusan_id', $request['jurusan']);

        return $query
            ->addColumn('dudi_name', function ($detail) {
                if (!empty($detail->dudi_id)) {
                    $getIdustri = Dudi::find($detail->dudi_id)->toArray();
                    return $getIdustri['name'];
                }
                return '-';
            })
            ->addColumn('guru_nip', function ($detail) {
                return empty($detail->guru_nip) ? '-' : $detail->guru_nip;
            })
            ->addColumn('guru_name', function ($detail) {
                return empty($detail->guru_name) ? '-' : $detail->guru_name;
            })
            ->addColumn('pembina_name', function ($detail) {
                return empty($detail->pembina_name) ? '-' : $detail->pembina_name;
            })
            ->addColumn('pembina_hp', function ($detail) {
                return empty($detail->pembina_hp) ? '-' : $detail->pembina_hp;
            })
            ->addColumn('status', function ($detail) {
                switch ($detail->status_pelaksana) {
                    case 'pending':
                        $badgeClass = 'bg-label-warning';
                        break;
                    case 'failed':
                        $badgeClass = 'bg-label-danger';
                        break;
                    case 'completed':
                        $badgeClass = 'bg-label-success';
                        break;
                    default:
                        $badgeClass = 'bg-label-secondary';
                }

                $badgeText = ucfirst($detail->status_pelaksana); // Huruf pertama kapital

                return '<span class="badge ' . $badgeClass . '">' . htmlspecialchars($badgeText) . '</span>';
            })
            ->addColumn('action', function ($detail) {
                return '
                <div class="d-flex align-items-center">
                    <a class="btn btn-icon" href="javascript:void(0);" data-permision="user-update" onclick="onEdit(this)" data-params="' . base64_encode(json_encode($detail)) . '">
                        <i class="ti ti-edit ti-md"></i>
                    </a>
                    <a class="btn btn-icon" href="javascript:void(0);" data-permision="user-update" onclick="onPrint(this)" data-params="' . base64_encode(json_encode($detail)) . '">
                        <i class="ti ti-printer ti-md"></i>
                    </a>
                    <div class="dropdown">
                        <a href="javascript:;" class="btn dropdown-toggle hide-arrow btn-icon p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical ti-md"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="onDetails(this)" data-params="' . base64_encode(json_encode($detail)) . '">Details</a>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="onHistory(this)" data-params="' . base64_encode(json_encode($detail)) . '">History</a>
                        </div>
                    </div>
                </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    public function industri($request)
    {
        $query = Dudi::select('id', 'name', 'pic_name', 'pic_phone', 'pic_jabatan')
            ->orderBy('name', 'DESC')
            ->whereNull('deleted_at');

        $query->where('is_active', true);
        
        if(!empty($request->input('jurusan'))){
            $query->where('jurusan_id', $request->input('jurusan'));
        }
        $data = $query->get();
        return $data->map(function ($item) {
            return [
                'id'            => $item->id,
                'name'          => ucwords($item->name),
                'pic_name'      => ucwords($item->pic_name),
                'pic_phone'     => ($item->pic_phone),
                'pic_jabatan'   => ucwords($item->pic_jabatan),
            ];
        });
    }
}
