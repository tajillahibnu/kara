<?php

namespace Modules\Pkl\Http\Controllers\Absensi;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Absensi\IjinSiswaPKLService;

class IjinSiswaPKLController extends Controller
{
    use ApiResponseTrait;
    protected $mainServices;
    public function __construct(IjinSiswaPKLService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    public function store(Request $request)
    {
        try {
            $aArrStore = $this->mainServices->store($request->all());
            return $this->apiResponse($aArrStore)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.' . $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $aArrUpdate = $this->mainServices->update($id, $request->all());
            return $this->apiResponse($aArrUpdate)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.'.$th->getMessage());
        }
    }

    public function proses(Request $request)
    {
        try {
            switch ($request->input('tipe')) {
                case 'completed':
                    $aArrProses = $this->mainServices->acc($request->input('id'), $request->all());
                    break;
                case 'rejected':
                    $aArrProses = $this->mainServices->rejected($request->input('id'), $request->all());
                    break;
                default:
                    $aArrProses = [];
                    break;
            }
            return $this->apiResponse($aArrProses)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.' . $th->getMessage());
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
