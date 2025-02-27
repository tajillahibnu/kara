<?php

namespace Modules\Pkl\Services\Pkl;

use App\Models\Jurusan;
use App\Services\DataTableService;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Pkl\Repositories\ProsesRegistrasiPklRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProsesPklService
{

    protected $repository;
    public function __construct(
        ProsesRegistrasiPklRepository $repository,
    ) {
        $this->repository = $repository;
    }

    public function acc_pkl($id, array $data)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            if (!empty($data['task'])) {
                $response['data'] = $this->repository->saveAccAll($id);
            } else {
                $response['data'] = $this->repository->saveAcc($id);
            }
        } catch (NotFoundHttpException $e) {
            $response['message'] = "Item with ID $id not found for update";
            throw new NotFoundHttpException($response['message']);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            throw new Exception("Failed to update item" . $e->getMessage(), 500);
        }
        return $response;
    }

    public function rejected_pkl($id, array $data)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            if (!empty($data['task'])) {
                $response['data'] = $this->repository->saveRejectAll($id);
            } else {
                $response['data'] = $this->repository->saveReject($id);
            }
            exit;
        } catch (NotFoundHttpException $e) {
            $response['message'] = "Item with ID $id not found for update";
            throw new NotFoundHttpException($response['message']);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            throw new Exception("Failed to update item" . $e->getMessage(), 500);
        }
        return $response;
    }


    /**
     * Menampilkan data dalam bentuk DataTable.
     *
     * @return mixed Data dalam format JSON untuk DataTable.
     */
    public function table()
    {
        $getSetting = getSiteMeta();
        $tahunPelajaran = $getSetting['kbm']['tahun_pelajaran'];

        return DataTableService::draw('pkl_registrations')
            ->select(['pkl_registrations.*', 'siswas.name', 'siswas.nis', 'siswas.rombel_name', 'siswas.jurusan_id'])
            ->join('siswas', [
                ['siswas.id', '=', 'pkl_registrations.siswa_id'],
            ])
            ->where('tahun_pelajaran', $tahunPelajaran)
            ->addColumn('jurusan', function ($detail) {
                return Cache::remember("jurusan_{$detail->jurusan_id}", now()->addMinutes(5), function () use ($detail) {
                    return Jurusan::find($detail->jurusan_id)->name ?? 'Unknown';
                });
            })
            ->addColumn('status_badge', function ($detail) {
                return getBadgeStatus($detail->status);
            })
            ->addColumn('action', function ($detail) {
                return '
                <div class="d-inline-block">
                    <a href="javascript:void(0);" class="btn btn-sm rounded-pill btn-icon dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true"><i class="ti ti-dots-vertical ti-md"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" data-popper-placement="bottom-end">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="editData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Edit</a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="confirmAll(this)" data-task="bypass" data-tipe="approved" data-params="' . base64_encode(json_encode($detail)) . '">Approve All</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="confirmAll(this)" data-task="bypass" data-tipe="rejected" data-params="' . base64_encode(json_encode($detail)) . '">Rejected All</a>
                        </li>
                    </ul>
                </div>
                ';
            })
            ->rawColumns(['status_badge', 'action'])
            ->toJson();
    }
}
