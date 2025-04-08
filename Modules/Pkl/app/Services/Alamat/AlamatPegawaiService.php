<?php

namespace Modules\Pkl\Services\Alamat;

use App\Models\AlamatPegawai;
use Exception;
use Modules\Pkl\Repositories\BasePklRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AlamatPegawaiService
{
    protected $repository;

    public function __construct(BasePklRepository $repository)
    {
        /**
         * Memangil Model yang digunakan di repository
         */
        $this->repository = $repository->setModel(new AlamatPegawai());
    }

    protected function prepareData(array $input)
    {
        foreach ($input as $fild => $value) {
            $dataToSave[$fild] = $value;
        }
        return $dataToSave;
    }

    public function storeUpdate(array $input, $pegawaiId, $primaryId = null)
    {
        $aArrData = [];
        if ($primaryId === null) {
            // Jika primaryId null, panggil metode store
            $aArrData = $this->store($input, $pegawaiId);
            $primaryId = $aArrData['id'];
        } elseif ($primaryId !== null) {
            // Jika primaryId tidak null, panggil metode update
            $aArrData = $this->update($input, $primaryId, $pegawaiId);
        }
        // Jika ini adalah alamat pertama, set sebagai default
        return $aArrData;
    }

    private function store(array $input, $pegawaiId)
    {
        $dataToStore = $this->prepareData($input);
        $dataToStore['pegawai_id'] = $pegawaiId;
        $response = $this->repository->create($dataToStore);
        $primaryId = $response['id'];
        if (AlamatPegawai::where('pegawai_id', $pegawaiId)->count() == 0) {
            $this->setDefaultAddress($pegawaiId, $primaryId);
        }
        if (!empty($input['alamat_utama'])) {
            $dataToUpdate['is_default'] = true;
            $this->setDefaultAddress($pegawaiId, $primaryId);
        }
        return $response;
    }

    private function update(array $input, $primaryId, $pegawaiId)
    {
        $dataToUpdate = $this->prepareData($input);
        $dataToUpdate['is_default'] = false;
        if (!empty($input['alamat_utama'])) {
            $dataToUpdate['is_default'] = true;
            $this->setDefaultAddress($pegawaiId, $primaryId);
        }

        $response = $this->repository->update($dataToUpdate, $primaryId);
        return $response;
    }

    public function setDefaultAddress($pegawaiId, $id = null)
    {
        $this->repository->update(['is_default' => false], [['pegawai_id', '=', $pegawaiId]]);
        $this->repository->update(['is_default' => true], [['id', '=', $id]]);
    }

    public function fetchAlamat($pegawaiId = null)
    {
        $response = $this->repository->all([
            ['pegawai_id', '=', $pegawaiId],
            ['deleted_at', 'IS', null],
        ]);
        return $response;
    }

    public function delete($id = null, $pegawaiId = null)
    {
        $response['statusCode'] = 200;
        try {
            $response = $this->repository->delete($id);
            if (AlamatPegawai::where('pegawai_id', $pegawaiId)->where('is_default', true)->count() == 0) {
                $addresses = $this->fetchAlamat($pegawaiId);
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
