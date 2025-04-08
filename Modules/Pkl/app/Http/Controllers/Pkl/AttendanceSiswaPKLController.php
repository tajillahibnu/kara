<?php

namespace Modules\Pkl\Http\Controllers\Pkl;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Pkl\Services\Pkl\AttendanceSiswaService;

class AttendanceSiswaPKLController extends Controller
{
    use ApiResponseTrait;
    protected $mainServices;
    public function __construct(AttendanceSiswaService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    public function read()
    {
        try {
            $siswaId = Auth::user()->biodata_id;
            $date = Carbon::now()->format('Y-m-d');
            $aArrStore = $this->mainServices->getDataBy($siswaId, $date);
            return $this->apiResponse($aArrStore)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.');
        }
    }

    public function ChekInOut(Request $request)
    {
        try {
            $aArrStore = $request->input();
            $siswaId = Auth::user()->biodata_id;
            $time = now();
            $aArrStore = $this->mainServices->ChekInOut($request->input(), $siswaId);
            return $this->apiResponse($aArrStore)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.');
        }
    }

    public function mainTable()
    {
        $siswaId = Auth::user()->biodata_id;
        return $this->mainServices->table($siswaId);
    }
}
