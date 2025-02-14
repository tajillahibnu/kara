<?php

namespace Modules\Pkl\Services\Setting;

use Exception;
use Illuminate\Support\Facades\Log;
use Modules\Pkl\Repositories\ConfigAppRepository;

class ConfigAppService
{
    protected $repository;
    public function __construct(ConfigAppRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getConfigApp()
    {
        try {
            $where[] = ['config_tipe', 'in', ['app', 'sekolah', 'smtp','kbm']];
            return $this->repository->all($where);
        } catch (Exception $e) {
            Log::error("General error: " . $e->getMessage());
            throw new Exception("Could not retrieve item", 500);
        }
    }

    public function update(array $data)
    {
        $response['success']    = false;
        $response['statusCode'] = 400;
        try {
            foreach ($data as $key => $value) {
                if ($value != '') {
                    $response[$key] = $this->repository->update(['config_value' => $value], [['config_name', '=', $key]]);
                }
            }
            $response['success']    = true;
            $response['statusCode'] = 200;
            $response['message']    = 'Berhasil memperbarui data';
        } catch (Exception $e) {
            $response['statusCode'] = 500;
            $response['message']    = $e->getMessage();
            Log::error("Error updating : " . $response['message']);
            throw new Exception("Failed to update item", 500);
        }
        return $response;
    }
}
