<?php

namespace Modules\Pkl\Services\Alamat;

use App\Models\AlamatSiswa;
use Exception;
use Modules\Pkl\Repositories\BasePklRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AlamatSiswaService
{
    protected $repository;

    public function __construct(BasePklRepository $repository)
    {
        /**
         * Memangil Model yang digunakan di repository
         */
        $this->repository = $repository->setModel(new AlamatSiswa());
    }

    protected function prepareData(array $input)
    {
        $dataToSave['label']    = $input['label'] ?? null;
        $dataToSave['alamat']   = $input['alamat'] ?? null;
        $dataToSave['provinsi'] = $input['provinsi'] ?? null;
        $dataToSave['kota']     = $input['kota'] ?? null;
        $dataToSave['kecamatan'] = $input['kecamatan'] ?? null;
        $dataToSave['desa']     = $input['desa'] ?? null;
        $dataToSave['kode_pos'] = $input['kode_pos'] ?? null;

        return $dataToSave;
    }

    public function save(array $input, $siswaId, $primaryId = null)
    {
        $aArrData = [];
        if ($primaryId === null) {
            // Jika primaryId null, panggil metode store
            $aArrData = $this->store($input, $siswaId);
            $primaryId = $aArrData['id'];
        } elseif ($primaryId !== null) {
            // Jika primaryId tidak null, panggil metode update
            $aArrData = $this->update($input, $primaryId, $siswaId);
        }
        // Jika ini adalah alamat pertama, set sebagai default
        return $aArrData;
    }

    private function store(array $input, $siswaId)
    {
        $dataToStore = $this->prepareData($input);
        $dataToStore['siswa_id'] = $siswaId;
        $response = $this->repository->create($dataToStore);
        $primaryId = $response['id'];
        if (AlamatSiswa::where('siswa_id', $siswaId)->count() == 0) {
            $this->setDefaultAddress($siswaId, $primaryId);
        }
        if (!empty($input['alamat_utama'])) {
            $dataToUpdate['is_default'] = true;
            $this->setDefaultAddress($siswaId, $primaryId);
        }
        return $response;
    }

    private function update(array $input, $primaryId, $siswaId)
    {
        $dataToUpdate = $this->prepareData($input);
        $dataToUpdate['is_default'] = false;
        if (!empty($input['alamat_utama'])) {
            $dataToUpdate['is_default'] = true;
            $this->setDefaultAddress($siswaId, $primaryId);
        }

        $response = $this->repository->update($dataToUpdate, $primaryId);
        return $response;
    }

    public function setDefaultAddress($siswaId, $id = null)
    {
        $this->repository->update(['is_default' => false], [['siswa_id', '=', $siswaId]]);
        $this->repository->update(['is_default' => true], [['id', '=', $id]]);
    }


    public function fetchAlamat($siswaId = null)
    {
        $response = $this->repository->all([
            ['siswa_id', '=', $siswaId],
            ['deleted_at', 'IS', null],
        ]);
        return $response;
    }

    public function delete($id = null, $siswaId = null)
    {
        $response['statusCode'] = 200;
        try {
            $response = $this->repository->delete($id);
            if (AlamatSiswa::where('siswa_id', $siswaId)->where('is_default',true)->count() == 0) {
                $addresses = $this->fetchAlamat($siswaId);
                if ($addresses->count() > 0) {
                    $firstAddress = $addresses[0]; // Mengakses alamat pertama
                    $primaryId = $firstAddress->id;
                    $dataToUpdate['is_default'] = true;
                    $response = $this->repository->update($dataToUpdate, $primaryId);
                }
            }
            return $response;
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException("Item with ID $id not found for deletion");
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            throw new Exception("Failed to delete item" . $e->getMessage(), 500);
        }
    }
}
