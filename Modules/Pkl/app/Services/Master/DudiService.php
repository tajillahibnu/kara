<?php

namespace Modules\Pkl\Services\Master;

use App\Models\Dudi;
use App\Services\DataTableService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Modules\Pkl\Repositories\BasePklRepository;
use Modules\Pkl\Repositories\DudiRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DudiService
{
    protected $repository;

    public function __construct(BasePklRepository $repository)
    {
        /**
         * Memangil Model yang digunakan di repository
         */
        $this->repository = $repository->setModel(new Dudi());
    }


    protected function prepareData(array $input)
    {
        return [
            'name' => $input['name'] ?? null,
            'email' => $input['email'] ?? null,
            'phone' => $input['phone'] ?? null,
            'address' => $input['address'] ?? null,
        ];
    }

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
            throw new Exception("Failed to update item", 500);
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
            Log::error("Error deleting item: " . $e->getMessage());
            throw new Exception("Failed to delete item" . $e->getMessage(), 500);
        }
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
            throw new Exception("Failed to update item", 500);
        }
        return $response;
    }

    public function table()
    {
        return DataTableService::draw('dudis')
            ->where('deleted_at', null)
            ->addColumn('status', function ($detail) {
                // $badgeClass = $detail->is_active ? 'bg-label-success' : 'bg-label-danger';
                // $badgeText = $detail->is_active ? 'Active' : 'Inactive';
                
                // return '<span class="badge  ' . $badgeClass . '">' . $badgeText . '</span>';
                
                $badgeText = $detail->is_active ? 'checked' : '';
                return '
                        <div class="w-75 d-flex justify-content-end">
                            <div class="form-check form-switch me-n3">
                            <input type="checkbox" class="form-check-input" name="'.$detail->id.'" data-params="' . base64_encode(json_encode($detail)) . '" onchange="setActive(this)" '.$badgeText.'>
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
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="editData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Edit</a>
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
