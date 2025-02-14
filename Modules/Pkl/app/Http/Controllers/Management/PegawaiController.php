<?php

namespace Modules\Pkl\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Pkl\Http\Requests\Management\PegawaiRequest;
use Modules\Pkl\Services\Management\PegawaiService;

class PegawaiController extends Controller
{
    use ApiResponseTrait;
    protected $mainServices;
    public function __construct(PegawaiService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    public function store(PegawaiRequest $request)
    {
        try {
            $aArrStore = $this->mainServices->store($request->input());
            return $this->apiResponse($aArrStore)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.');
        }
    }

    public function update(PegawaiRequest $request, $id)
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
