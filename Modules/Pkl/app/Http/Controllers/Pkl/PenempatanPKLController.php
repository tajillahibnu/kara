<?php

namespace Modules\Pkl\Http\Controllers\Pkl;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Pkl\PenempatanPKLService;

class PenempatanPKLController extends Controller
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
    public function __construct(PenempatanPKLService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    public function combobox_dudi()
    {
        $data = $this->mainServices->industri(false);
        return $this->apiResponse($data)->send();
    }

    public function store(Request $request)
    {
        try {
            $registerId = $request->input('taskID');
            $aArrStore = $this->mainServices->store($request->input(), $registerId);
            return $this->apiResponse($aArrStore)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.');
        }
    }

    public function mainTable(Request $request)
    {
        return $this->mainServices->table($request->input());
    }
}
