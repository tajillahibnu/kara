<?php

namespace Modules\Pkl\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Data\KelasService;

class KelasController extends Controller
{
    use ApiResponseTrait;
    /**
     * Service utama untuk operasi data.
     *
     * @var DefaultService
     */
    protected $mainServices;
    /**
     * Konstruktor DefaultController.
     *
     * @param DefaultService $mainServices Service untuk operasi utama.
     */
    public function __construct(KelasService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    public function enrolSiswa(Request $request)
    {
        try {
            $dataKelas = $request->input('dataRombel');
            $dataSiswa = $request->input('dataSiswa');
            $aArrUpdate = $this->mainServices->kelasSiswa($dataKelas, $dataSiswa);
            return $this->apiResponse($aArrUpdate)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.'.$th->getMessage());
        }
    }

    /**
     * Mendapatkan data tabel utama.
     *
     * @return mixed Data tabel utama yang diproses oleh service.
     */
    public function mainTable()
    {
        return $this->mainServices->table();
    }

    /**
     * Mendapatkan data tabel utama.
     *
     * @return mixed Data tabel utama yang diproses oleh service.
     */
    public function tableSiswa(Request $request)
    {
        $rombelId = $request->input('kelas');
        $jurusanId = $request->input('jurusan');
        $tingkatId = $request->input('tingkat');
        $tipe = $request->input('tipe');
        return $this->mainServices->tableSiswa($rombelId,$jurusanId,$tingkatId,$tipe);
    }
}
