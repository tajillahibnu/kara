<?php

namespace Modules\Pkl\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Pkl\Http\Requests\Management\SiswaRequest;
use Modules\Pkl\Services\Management\SiswaService;

class SiswaController extends Controller
{
    use ApiResponseTrait;
    protected $mainServices;
    public function __construct(SiswaService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    public function store(SiswaRequest $request)
    {
        try {
            $aArrStore = $this->mainServices->store($request->input());
            return $this->apiResponse($aArrStore)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.');
        }
    }

    public function update(SiswaRequest $request, $id)
    {
        try {
            $aArrUpdate = $this->mainServices->update($id, $request->input());
            return $this->apiResponse($aArrUpdate)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->input('id');
            $aArrDelete = $this->mainServices->delete($id);
            return $this->apiResponse($aArrDelete)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.');
        }
    }

    public function mainTable()
    {
        return $this->mainServices->table();
    }
}
