<?php

namespace Modules\Pkl\Repositories;

use App\Models\Dudi as MainModel;
use App\Models\Role;
use App\Models\User;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DudiRepository extends BaseRepository
{
    public function __construct(MainModel $model)
    {
        parent::__construct($model);
    }

    public function updateData(array $dataToUpdate, $dudiId = null)
    {

        DB::beginTransaction(); // Mulai transaction
        try {
            if (!empty($dataToUpdate['password'])) {
                $dataToUpdate['password'] = Hash::make($dataToUpdate['password']);
            } else {
                unset($dataToUpdate['password']);
            }

            $response = $this->update($dataToUpdate, $dudiId);
            $getRole = Role::where('slug', 'iduka')->first();
            $query = User::where('biodata_id', $response['id'])
                ->where('primary_role_id', $getRole->id);
            if (!$query->exists()) {
                User::create([
                    'name'       => $response['name'],
                    'username'   => $response['username'], // Gunakan username yang sudah dibuat
                    'email'      => $response['email'],
                    'password'   => $response['password'],
                    'biodata_id' => $response['id'],
                    'is_siswa'          => false,
                    'primary_role_id'   => $getRole->id,
                ]);
            } else {
                $updateUser = [
                    'username' => $response['username'],
                    'email' => $response['email'],
                ];
                // Update password hanya jika ada perubahan
                if (!empty($dataToUpdate['password'])) {
                    $updateUser['password'] = $dataToUpdate['password'];
                }
                $query->update($updateUser);
            }
            DB::commit(); // Simpan perubahan ke database
        } catch (NotFoundHttpException $e) {
            DB::rollBack();
            throw new NotFoundHttpException($response['message']);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to update item" . $e->getMessage(), 500);
        }
        return $response;
    }

    public function infoDashboard($dudiId)
    {
        try {
            $result = DB::select("SELECT 
                COUNT(*) AS siswa,
                SUM(CASE WHEN jk = 'L' THEN 1 ELSE 0 END) AS pria,
                SUM(CASE WHEN jk = 'P' THEN 1 ELSE 0 END) AS wanita
            FROM view_pkl_siswa WHERE dudi_id = ? AND status_register = 'completed'", [$dudiId]);

            // Memeriksa apakah ada hasil
            if (!empty($result)) {
                foreach ($result as $value) {
                    foreach ($value as $key => $item) {
                        $aArrData['total'][$key] = $item;
                    }
                }
            } else {
                $aArrData['total'] = []; // Atau bisa diisi dengan nilai default
            }
        } catch (Exception $e) {
            throw new Exception("Failed to update item" . $e->getMessage(), 500);
        }
        return $aArrData;
    }
}
