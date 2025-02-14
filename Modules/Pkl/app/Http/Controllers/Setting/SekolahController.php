<?php

namespace Modules\Pkl\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Setting\ConfigAppService;

class SekolahController extends Controller
{
    use ApiResponseTrait;
    protected $mainServices;
    public function __construct(ConfigAppService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    public function read(Request $request)
    {
        $data = $request->input();
        try {
            $response = $this->mainServices->getConfigApp();
            return $this->apiResponse($response)->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.');
        }
    }

    public function update(Request $request)
    {
        $data = $request->input();
        try {
            $r = $this->mainServices->update($data);
            return $this->apiResponse($r)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.' . $th->getMessage());
        }
    }
}
