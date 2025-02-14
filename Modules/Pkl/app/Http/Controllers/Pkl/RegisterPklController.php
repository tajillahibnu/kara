<?php

namespace Modules\Pkl\Http\Controllers\Pkl;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Pkl\RegisterPklService;

class RegisterPklController extends Controller
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
    public function __construct(RegisterPklService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    public function register_pkl(Request $request){
        try {
            $aArrStore = $this->mainServices->register($request->input());
            return $this->apiResponse($aArrStore)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.');
        }
    }

    public function combosiswa(Request $request)
    {
        $data = $this->mainServices->combo_siswa($request->input('tingkat_id'),$request->input('jurusan_id'));
        return $this->apiResponse($data)->send();
    }
    public function combopriode(Request $request)
    {
        $data = $this->mainServices->priode_pkl();
        return $this->apiResponse($data)->send();
    }

    public function tableregistrasi(Request $request)
    {

        return $this->mainServices->table_registrasi($request->input());
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
}
