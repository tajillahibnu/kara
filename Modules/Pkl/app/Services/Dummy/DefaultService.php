<?php

namespace Modules\Pkl\Services\Dummy;

use App\Models\User;
use App\Services\DataTableService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Modules\Pkl\Repositories\BasePklRepository;
use Modules\Pkl\Repositories\Dummy\DefaultRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultService
{
    // Properti untuk menyimpan instance repository yang digunakan
    protected $repository;

    /**
     * Constructor 1: Menggunakan repository generik dengan model yang dapat diatur secara dinamis.
     *
     * @param BasePklRepository $repository
     */
    public function __construct(BasePklRepository $repository)
    {
        /**
         * Constructor ini digunakan jika developer ingin memanfaatkan repository generik
         * dengan model yang dapat diubah-ubah sesuai kebutuhan.
         * Contoh: Repository dapat digunakan untuk berbagai model selain User.
         * Keunggulan: Fleksibilitas tinggi, mempermudah penggunaan ulang kode.
         * Kekurangan: Membutuhkan penyesuaian model secara manual setiap kali diperlukan.
         */
        $this->repository = $repository->setModel(new User());
    }


    /**
     * Constructor 2: Menggunakan repository spesifik yang sudah ditargetkan untuk model tertentu.
     *
     * @param DefaultRepository $repository
     */
    // public function __construct(
    //     DefaultRepository $repository,
    // ) {
    //     /**
    //      * Constructor ini digunakan jika developer ingin memanfaatkan repository spesifik
    //      * (dalam hal ini, `DefaultRepository`) yang sudah ditargetkan untuk model tertentu.
    //      * Contoh: Repository ini dioptimalkan untuk entitas Dummy/Default.
    //      * Keunggulan: Kode lebih sederhana, tidak perlu menentukan model secara manual.
    //      * Kekurangan: Kurang fleksibel jika repository ingin digunakan untuk model lain.
    //      */
    //     $this->repository = $repository;
    // }


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
            $response = $this->repository->create($dataToSave);
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
            throw new Exception("Failed to update item ". $response['message'], 500);
        }
        return $response;
    }

    public function status($id, array $input)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $dataToUpdate['is_active'] = !$input['is_active']?? true;
            // print_r($dataToUpdate);
            // exit;
            $response['data'] = $this->repository->update($dataToUpdate, $id);
        } catch (NotFoundHttpException $e) {
            $response['message'] = "Item with ID $id not found for update";
            throw new NotFoundHttpException($response['message']);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error("Error updating : " . $response['message']);
            throw new Exception("Failed to update item ". $response['message'], 500);
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
            $response = $this->repository->delete($id);
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
    public function table()
    {
        return DataTableService::draw('users')
            ->where('is_siswa', true)
            // ->select(['users.id', 'users.name', 'users.email', 'users.is_active', 'roles.name AS role_name'])
            // ->join('roles', [
            //     ['roles.id', '=', 'users.primary_role_id'],
            // ])
            ->addColumn('status', function ($detail) {
                $badgeClass = $detail->is_active ? 'bg-label-success' : 'bg-label-danger';
                $badgeText = $detail->is_active ? 'Active' : 'Inactive';

                return '<span class="badge  ' . $badgeClass . '">' . $badgeText . '</span>';
            })
            ->addColumn('action', function ($detail) {
                return '
                <div class="d-inline-block">
                    <a href="javascript:void(0);" class="btn btn-sm rounded-pill btn-icon dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true"><i class="ti ti-dots-vertical ti-md"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" data-popper-placement="bottom-end">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="editData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Edit Account</a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="deleteData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Delete</a>
                        </li>
                    </ul>
                </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }
}
