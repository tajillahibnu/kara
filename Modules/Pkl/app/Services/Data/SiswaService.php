<?php

namespace Modules\Pkl\Services\Data;

use App\Models\Dudi;
use App\Models\Jurusan;
use App\Models\PklRegistration;
use App\Models\Rombel;
use App\Services\DataTableService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Pkl\Repositories\SiswaRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiswaService
{
    // Properti untuk menyimpan instance repository yang digunakan
    protected $repository;

    /**
     * Constructor 1: Menggunakan repository generik dengan model yang dapat diatur secara dinamis.
     *
     * @param BasePklRepository $repository
     */
    public function __construct(SiswaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Menyiapkan data sebelum disimpan ke dalam database.
     *
     * @param array $input Data masukan dari user.
     * @return array Data yang sudah diproses dan siap disimpan.
     */
    protected function prepareData(array $input)
    {
        return [
            'name' => $input['name'] ?? null,
            'email' => $input['email'] ?? null,
            'tanggal_lahir' => $input['tanggal_lahir'] ?? '1992-01-01',
            'alamat' => $input['alamat'] ?? null,
            'tingkat_id' => $input['tingkat_id'] ?? null,
            'jurusan_id' => $input['jurusan_id'] ?? null,
        ];
    }

    /**
     * Menyimpan data baru ke dalam database.
     *
     * @param array $input Data masukan dari user.
     * @return array Respons hasil penyimpanan.
     */
    public function store(array $input)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $dataToSave = $this->prepareData($input);
            // print_r($dataToSave);
            // exit;
            $response = $this->repository->createSiswa($dataToSave);
            $response['data'] = $input;
        } catch (QueryException $e) {
            $response['statusCode'] = 400;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    /**
     * Memperbarui data yang sudah ada di database.
     *
     * @param int $id ID data yang akan diperbarui.
     * @param array $input Data masukan dari user.
     * @return array Respons hasil pembaruan.
     * @throws NotFoundHttpException Jika data tidak ditemukan.
     * @throws Exception Jika terjadi kesalahan lain.
     */
    public function update($id, array $input)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $dataToUpdate = $this->prepareData($input);
            $response['data'] = $this->repository->update($dataToUpdate, $id);
        } catch (NotFoundHttpException $e) {
            $response['message'] = "Item with ID $id not found for update";
            throw new NotFoundHttpException($response['message']);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error("Error updating : " . $response['message']);
            throw new Exception("Failed to update item" . $response['message'], 500);
        }
        return $response;
    }

    public function status($id, array $input)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $dataToUpdate['is_active'] = !$input['is_active'] ?? true;
            // print_r($dataToUpdate);
            // exit;
            $response['data'] = $this->repository->update($dataToUpdate, $id);
        } catch (NotFoundHttpException $e) {
            $response['message'] = "Item with ID $id not found for update";
            throw new NotFoundHttpException($response['message']);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error("Error updating : " . $response['message']);
            throw new Exception("Failed to update item" . $response['message'], 500);
        }
        return $response;
    }

    /**
     * Menghapus data dari database.
     *
     * @param int|null $id ID data yang akan dihapus.
     * @return array Respons hasil penghapusan.
     * @throws NotFoundHttpException Jika data tidak ditemukan.
     * @throws Exception Jika terjadi kesalahan lain.
     */
    public function delete($id = null)
    {
        $response['statusCode'] = 200;
        try {
            $response = $this->repository->deleteSiswa($id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException("Item with ID $id not found for deletion");
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error("Error deleting item: " . $e->getMessage());
            throw new Exception("Failed to delete item" . $e->getMessage(), 500);
        }
    }

    /**
     * Menampilkan data dalam bentuk DataTable.
     *
     * @return mixed Data dalam format JSON untuk DataTable.
     */
    public function table($role = null)
    {
        $query = DataTableService::draw('siswas');

        if ($role === 'wali_kelas') {
            $user = Auth::user();
            $getRombel = Rombel::where('walikelas_id', $user->biodata_id)->first();
            $query->where('rombel_id', $getRombel->id);
        }

        if ($role === 'iduka') {
            $siswaIds = PklRegistration::where('dudi_id', Auth::user()->biodata_id)
                ->pluck('siswa_id')
                ->map(fn($id) => (string)$id)
                ->toArray();;
            $query->where('id', 'IN', $siswaIds);
        }

        return $query->where('deleted_at', null)
            ->addColumn('jurusan', function ($detail) {
                return Cache::remember("jurusan_{$detail->jurusan_id}", now()->addMinutes(5), function () use ($detail) {
                    return Jurusan::find($detail->jurusan_id)->name ?? 'Unknown';
                });
            })
            ->addColumn('status', function ($detail) {
                // $badgeClass = $detail->is_active ? 'bg-label-success' : 'bg-label-danger';
                // $badgeText = $detail->is_active ? 'Active' : 'Inactive';

                // return '<span class="badge  ' . $badgeClass . '">' . $badgeText . '</span>';
                $badgeText = $detail->is_active ? 'checked' : '';
                return '
                        <div class="w-75 d-flex justify-content-end">
                            <div class="form-check form-switch me-n3">
                            <input type="checkbox" class="form-check-input" name="' . $detail->id . '" data-params="' . base64_encode(json_encode($detail)) . '" onchange="setActive(this)" ' . $badgeText . '>
                            </div>
                        </div>
                ';
            })
            ->addColumn('action', function ($detail) use ($role) {
                $btnMore = '';
                $btnview = '';
                $btnview .= '<a class="btn btn-icon" href="javascript:void(0);" data-permision="user-update" onclick="onEdit(this)" data-params="' . base64_encode(json_encode($detail)) . '">
                                <i class="ti ti-eye ti-md"></i>
                            </a>';
                switch ($role) {
                    case 'wali_kelas':
                        $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="onDetails(this)" data-params="' . base64_encode(json_encode($detail)) . '">Reset Password</a>';
                        break;
                    case 'super_admin':
                    case 'admin_sekolah':
                        $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="editData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Edit</a>';
                        $btnMore .= '<div class="dropdown-divider"></div>';
                        $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="onDetails(this)" data-params="' . base64_encode(json_encode($detail)) . '">Reset Password</a>';
                        $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="deleteData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Delete</a>';
                        break;
                    default:

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
            ->rawColumns(['status', 'action'])
            ->toJson();
    }
}
