<?php

namespace Modules\Pkl\Services\Management;

use App\Services\DataTableService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Modules\Pkl\Repositories\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PegawaiService
{
    protected $repository;

    public function __construct(
        UserRepository $repository,
    ) {
        $this->repository = $repository;
    }

    protected function prepareData(array $input)
    {
        return [
            'name' => $input['name'] ?? null,
            'email' => $input['email'] ?? null,
        ];
    }

    public function store(array $input)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $dataToSave = $this->prepareData($input);
            $dataToSave['username'] = $input['email'];
            $dataToSave['name'] = $input['name'];
            $dataToSave['email'] = $input['email'];
            $dataToSave['password'] = 'password';
            $dataToSave['primary_role_id'] = 3;
            $dataToSave['is_siswa'] = false;
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

    public function table()
    {
        return DataTableService::draw('users')
            ->select(['users.id', 'users.name', 'users.email', 'users.is_active', 'roles.name AS role_name', 'email_verified_at'])
            ->where('is_siswa', false)
            ->join('roles', [
                ['roles.id', '=', 'users.primary_role_id'],
            ])
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
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="editRoles(this)" data-params="' . base64_encode(json_encode($detail)) . '">Edit Roles</a>
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
