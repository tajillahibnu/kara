<?php

namespace Modules\Pkl\Http\Controllers\Pkl;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Pkl\ProsesPklService;

class ProsesRegisterController extends Controller
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
    public function __construct(ProsesPklService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    public function proses(Request $request)
    {
        try {
            switch ($request->input('tipe')) {
                case 'completed':
                    $aArrProses = $this->mainServices->acc_pkl($request->input('id'), $request->input());
                    break;
                case 'rejected':
                    $aArrProses = $this->mainServices->rejected_pkl($request->input('id'), $request->input());
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

    public function mainTable()
    {
        return $this->mainServices->table();
    }
}
