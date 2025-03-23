<?php

namespace Modules\Pkl\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Upload\SiswaFileService;

class UploadSiswaController extends Controller
{
    use ApiResponseTrait;
    protected $mainServices;
    public function __construct(SiswaFileService $mainServices)
    {
        $this->mainServices = $mainServices;
    }


    public function uploadSiswaJurusan(Request $request)
    {
        $data = $request->input();
        try {
            $response = $this->mainServices->uploadSiswaJurusan($request);
            return $this->apiResponse($response)->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.' . $th->getMessage());
        }
    }

    public function mainTable()
    {
        return $this->mainServices->table();
    }

    public function tableSiswa(Request $request)
    {
        return $this->mainServices->tableSiswa($request);
    }
}
