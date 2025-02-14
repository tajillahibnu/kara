<?php

namespace Modules\Pkl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Modules\Pkl\Services\ComboMasterService;

class ComboMasterController extends Controller
{
    use ApiResponseTrait;
    protected $mainServices;
    public function __construct(ComboMasterService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    public function combo($tipe)
    {
        switch ($tipe) {
            case 'tingkat':
                $data = $this->mainServices->tingkat();
                return $this->apiResponse($data)->send();
                break;
            case 'jurusan':
                $data = $this->mainServices->jurusan();
                return $this->apiResponse($data)->send();
                break;
            case 'tahun-pelajaran':
                $data = $this->mainServices->tahun_pelajaran();
                return $this->apiResponse($data)->send();
                break;
            case 'roles':
                $data = $this->mainServices->roles();
                return $this->apiResponse($data)->send();
                break;
            default:
                return response()->json(['error' => 'Tipe tidak valid'], 400);
        }

    }
}
