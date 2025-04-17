<?php

namespace Modules\Pkl\Services\Absensi;

use App\Models\IjinSiswaPkl;
use App\Models\PklRegistration;
use App\Services\DataTableService;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Modules\Pkl\Repositories\BasePklRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IjinSiswaPKLService
{
    protected $repository;

    public function __construct(BasePklRepository $repository)
    {
        $this->repository = $repository->setModel(new IjinSiswaPkl());
    }


    private function validation(array $input, string $mode = 'store')
    {

        $rules['tanggal_mulai']     = 'required|date';
        $rules['tanggal_selesai']   = 'required|date';
        $rules['alasan']    = 'required|string|max:1000';
        $rules['lampiran']  = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';

        if ($mode === 'store') {
            $rules['siswa_id'] = 'required|exists:siswas,id';
        }

        $messages = [
            'siswa_id.required'         => 'Siswa tidak ditemukan.',
            'siswa_id.exists'           => 'ID siswa tidak valid.',
            'tanggal_mulai.required'    => 'Tanggal izin wajib diisi.',
            'tanggal_selesai.required'  => 'Tanggal izin wajib diisi.',
            'alasan.required'             => 'Alasan izin wajib diisi.',
            'lampiran.mimes'            => 'Lampiran hanya boleh berupa JPG, PNG, atau PDF.',
        ];

        return Validator::make($input, $rules, $messages);
    }

    public function store(array $data)
    {
        $data['siswa_id'] = Auth::user()->biodata_id;
        $data['tanggal_mulai'] = Carbon::createFromFormat('d-m-Y', $data['tanggal_mulai'])->format('Y-m-d');
        $data['tanggal_selesai'] = Carbon::createFromFormat('d-m-Y', $data['tanggal_selesai'])->format('Y-m-d');


        $validator = $this->validation($data, 'store');

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $dataToSave = $validator->validated();

        $getSiswaPkl = PklRegistration::where('siswa_id',$data['siswa_id'])->where('status_pelaksana','completed')->first();
        $dataToSave['dudi_id']      = $getSiswaPkl->dudi_id;
        $dataToSave['pegawai_id']   = $getSiswaPkl->pegawai_id;

        if (request()->hasFile('lampiran')) {
            $dataToSave['lampiran'] = request()->file('lampiran')->store('lampiran_ijin', 'public');
        }

        try {
            return $this->repository->create($dataToSave);
        } catch (Exception $e) {
            throw new Exception("Gagal menyimpan data. " . $e->getMessage(), 500);
        }
    }

    public function update($id, array $data)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $data['tanggal_mulai'] = Carbon::createFromFormat('d-m-Y', $data['tanggal_mulai'])->format('Y-m-d');
            $data['tanggal_selesai'] = Carbon::createFromFormat('d-m-Y', $data['tanggal_selesai'])->format('Y-m-d');

            $validator = $this->validation($data, 'update');

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $dataToUpdate = $validator->validated();

            if (request()->hasFile('lampiran')) {
                $dataToUpdate['lampiran'] = request()->file('lampiran')->store('lampiran_ijin', 'public');
            }

            $response = $this->repository->update($dataToUpdate, $id);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            throw new Exception($e->getMessage(), 500);
        }
        return $response;
    }

    public function delete($id = null)
    {
        $response['statusCode'] = 200;
        try {
            $response = $this->repository->delete($id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException("Item with ID $id not found for deletion");
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            throw new Exception("Failed to delete item" . $e->getMessage(), 500);
        }
    }

    public function table()
    {
        $query = DataTableService::draw('ijin_siswa_pkls');

        $slugRole = session('active_role_slug');


        if ($slugRole === 'iduka' || $slugRole === 'pendamping_pkl') {
            $query->select(['ijin_siswa_pkls.*','siswas.name','siswas.nis'])
            ->join('siswas', [
                ['siswas.id', '=', 'ijin_siswa_pkls.siswa_id'],
            ]);

            if($slugRole === 'pendamping_pkl'){
                $query->where('ijin_siswa_pkls.pegawai_id', Auth::user()->biodata_id);
            }else{
                $query->where('ijin_siswa_pkls.dudi_id', Auth::user()->biodata_id);
            }
        }
        if ($slugRole === 'siswa') {
            $query->where('siswa_id', Auth::user()->biodata_id);
        }

        return $query
            ->addColumn('lampiran', function ($detail) {
                return $detail->lampiran ?? '-';
            })
            ->addColumn('status_pembimbing_instansi', function ($detail) {
                return getBadgeStatus($detail->status_pembimbing_instansi);
            })
            ->addColumn('status_guru_pembimbing', function ($detail) {
                return getBadgeStatus($detail->status_guru_pembimbing);
            })
            ->addColumn('tanggal_range', function ($detail) {
                $mulai = Carbon::parse($detail->tanggal_mulai);
                $selesai = Carbon::parse($detail->tanggal_selesai);

                if ($mulai->equalTo($selesai)) {
                    return $mulai->format('d M Y');
                } else {
                    return $mulai->format('d M Y') . ' - ' . $selesai->format('d M Y');
                }
            })
            ->addColumn('note', function ($detail) {
                $deskripsi = strip_tags($detail->alasan); // hilangkan tag HTML kalau ada
                $limit = 100;

                if (strlen($deskripsi) > $limit) {
                    $short = substr($deskripsi, 0, $limit) . '...';
                    return "<div class='column-deskripsi'>
                                <span class='short-text'>{$short}</span>
                                <span class='full-text d-none'>{$deskripsi}</span>
                                <span class='read-more'>Read more</span>
                            </div>";
                } else {
                    return "<div class='column-deskripsi'>{$deskripsi}</div>";
                }
            })
            ->addColumn('action', function ($detail) use ($slugRole) {

                $mulai = Carbon::parse($detail->tanggal_mulai);
                $selesai = Carbon::parse($detail->tanggal_selesai);
                $detail->btnProgress =  '';

                if ($mulai->equalTo($selesai)) {
                    $detail->tanggal_range =  $mulai->format('d M Y');
                } else {
                    $detail->tanggal_range =  $mulai->format('d M Y') . ' - ' . $selesai->format('d M Y');
                }

                $btnMore = '';
                $btnview = '';

                switch ($slugRole) {
                    case 'iduka':
                        $detail->btnProgress =  $detail->status_pembimbing_instansi === 'pending' ? '
                            <button type="button" id="btnRjct" data-params="" data-tipe="rejected" onclick="confirm(this)" class="btn btn-danger waves-effect">
                                <i class="fas fa-times mr-2"></i> Tolak
                            </button>
                            <button type="button" id="btnOk" data-params="" data-tipe="completed" onclick="confirm(this)" class="btn btn-success waves-effect waves-light">
                                <i class="fas fa-check mr-2"></i> Setujui
                            </button>' : '';
                        $btnview .= '<a class="btn btn-icon" href="javascript:void(0);" data-permision="user-update" onclick="onView(this)" data-params="' . base64_encode(json_encode($detail)) . '"><i class="ti ti-eye ti-md"></i></a>';
                        $btnMore = '';
                        break;
                    case 'pendamping_pkl':
                        $detail->btnProgress =  $detail->status_guru_pembimbing === 'pending' ? '
                            <button type="button" id="btnRjct" data-params="" data-tipe="rejected" onclick="confirm(this)" class="btn btn-danger waves-effect">
                                <i class="fas fa-times mr-2"></i> Tolak
                            </button>
                            <button type="button" id="btnOk" data-params="" data-tipe="completed" onclick="confirm(this)" class="btn btn-success waves-effect waves-light">
                                <i class="fas fa-check mr-2"></i> Setujui
                            </button>' : '';
                        $btnview .= '<a class="btn btn-icon" href="javascript:void(0);" data-permision="user-update" onclick="onView(this)" data-params="' . base64_encode(json_encode($detail)) . '"><i class="ti ti-eye ti-md"></i></a>';
                        $btnMore = '';
                        break;
                    default:
                        $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="onEdit(this)" data-params="' . base64_encode(json_encode($detail)) . '">Edit</a>';
                        $btnMore .= '<div class="dropdown-divider"></div>';
                        $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="deleteData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Delete</a>';
                        break;
                }

                $btnDropdown = $btnMore === '' ? '' : '
                        <div class="dropdown">
                            <a href="javascript:;" class="btn dropdown-toggle hide-arrow btn-icon p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical ti-md"></i></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                ' . $btnMore . '
                            </div>
                        </div>
                ';

                return '
                    <div class="d-flex align-items-center">
                        ' . $btnview . '
                        ' . $btnDropdown . '
                    </div>
                    ';
            })
            ->rawColumns(['note', 'status_pembimbing_instansi', 'status_guru_pembimbing', 'action'])
            ->toJson();
    }

    public function acc($id, $data)
    {
        $slugRole = session('active_role_slug');
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            // $dataToUpdate['tanggal_mulai'] = Carbon::createFromFormat('d-m-Y', $data['tanggal_mulai'])->format('Y-m-d');

            if ($slugRole == 'iduka') {
                $dataToUpdate['status_pembimbing_instansi'] = 'approved';
            }

            if ($slugRole == 'pendamping_pkl') {
                $dataToUpdate['status_guru_pembimbing'] = 'approved';
            }

            if (!empty($dataToUpdate)) {
                $response = $this->repository->update($dataToUpdate, $id);
            } else {
                throw new Exception('Role tidak terdaftar', 500);
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            throw new Exception($e->getMessage(), 500);
        }
        return $response;
    }

    public function rejected($id, $data)
    {
        $slugRole = session('active_role_slug');
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            // $dataToUpdate['tanggal_mulai'] = Carbon::createFromFormat('d-m-Y', $data['tanggal_mulai'])->format('Y-m-d');

            if ($slugRole == 'iduka') {
                $dataToUpdate['status_pembimbing_instansi'] = 'rejected';
            }

            if ($slugRole == 'pendamping_pkl') {
                $dataToUpdate['status_guru_pembimbing'] = 'rejected';
            }

            if (!empty($dataToUpdate)) {
                $response = $this->repository->update($dataToUpdate, $id);
            } else {
                throw new Exception('Role tidak terdaftar', 500);
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            throw new Exception($e->getMessage(), 500);
        }
        return $response;
    }
}
