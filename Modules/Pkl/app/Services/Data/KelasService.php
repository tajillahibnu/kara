<?php

namespace Modules\Pkl\Services\Data;

use App\Services\DataTableService;
use Exception;
use Modules\Pkl\Repositories\EnrolRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class KelasService
{
    protected $enrol;

    public function __construct(EnrolRepository $enrol)
    {
        $this->enrol = $enrol;
    }


    public function kelasSiswa(array $dataKelas, array $dataSiswa)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $siswaId    = $dataSiswa['id'];
            $RombelId   = $dataKelas['id'];
            $response['data'] = $this->enrol->siswaToKelas($RombelId, $siswaId);
        } catch (NotFoundHttpException $e) {
            $response['message'] = "Item with ID $RombelId not found for update";
            throw new NotFoundHttpException($response['message']);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error("Error updating : " . $response['message']);
            throw new Exception("Failed to update item", 500);
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
        return DataTableService::draw('rombels')
            ->where('deleted_at', null)
            ->where('is_active', true)
            ->where('tipe', 'KBM')
            ->addColumn('status', function ($detail) {
                $badgeText = $detail->is_active ? 'checked' : '';
                return '
                        <div class="w-75 d-flex justify-content-end">
                            <div class="form-check form-switch me-n3">
                            <input type="checkbox" class="form-check-input" name="' . $detail->id . '" data-params="' . base64_encode(json_encode($detail)) . '" onchange="setActive(this)" ' . $badgeText . '>
                            </div>
                        </div>
                ';
            })
            ->addColumn('action', function ($detail) {
                return '
                <div class="d-inline-block">
                    <a href="javascript:void(0);" class="btn btn-sm rounded-pill btn-icon dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true"><i class="ti ti-dots-vertical ti-md"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" data-popper-placement="bottom-end">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="editData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Detail</a>
                        </li>
                    </ul>
                </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    /**
     * Menampilkan data dalam bentuk DataTable.
     *
     * @return mixed Data dalam format JSON untuk DataTable.
     */
    public function tableSiswa($rombelId, $jurusanId, $tingkatId, $tipe)
    {
        $where['deleted_at'] = null;
        $where['jurusan_id'] = $jurusanId;
        $where['tingkat_id'] = $tingkatId;
        // if ($tipe == 'siswa') {
        //     $where['rombel_id'] = $id;
        // }else{
        //     $where['rombel_id'] = $id;
        // }
        return DataTableService::draw('siswas')
            ->where($where)
            ->where(null, null, null, function ($query) use ($tipe, $rombelId) {
                $query->when($tipe == 'siswa', function ($q) use ($rombelId) {
                    $q->where('rombel_id', $rombelId);
                })->when($tipe != 'siswa', function ($q) use ($rombelId) {
                    $q->where('rombel_id', null);
                    // $q->where('rombel_id', '!=', $id);
                });
            })
            ->addColumn('status', function ($detail) {
                $badgeText = $detail->is_active ? 'checked' : '';
                return '
                        <div class="w-75 d-flex justify-content-end">
                            <div class="form-check form-switch me-n3">
                            <input type="checkbox" class="form-check-input" name="' . $detail->id . '" data-params="' . base64_encode(json_encode($detail)) . '" onchange="setActive(this)" ' . $badgeText . '>
                            </div>
                        </div>
                ';
            })
            ->addColumn('action', function ($detail) use ($tipe) {
                if ($tipe == 'siswa') {
                    return '
                    <div class="d-inline-block">
                        <a href="javascript:void(0);" class="btn btn-sm rounded-pill btn-icon dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true"><i class="ti ti-dots-vertical ti-md"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end m-0" data-popper-placement="bottom-end">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="editData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Reset Password</a>
                            </li>
                        </ul>
                    </div>
                    ';
                } else {
                    return '
                    <div class="d-inline-block text-nowrap">
                        <button type="button" class="btn btn-sm btn-icon btn-primary waves-effect waves-light" onclick="enrolSiswa(this)" data-params="' . base64_encode(json_encode($detail)) . '"><i class="ti ti-plus ti-md"></i></button>
                    </div>';
                }
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }
}
