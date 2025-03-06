<?php

namespace Modules\Pkl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Dashboard\SuperadminService;

class DashboardController extends Controller
{
    use ApiResponseTrait;
    protected $superadminServices;
    public function __construct(SuperadminService $superadminServices)
    {
        $this->superadminServices = $superadminServices;
    }

    public function show()
    {
        $slugRole = session('active_role_slug');
        switch ($slugRole) {
            case 'super_admin':
            case 'admin_sekolah':
                $dataService = $this->superadminServices->info();
                break;
            default:
                # code...
                // echo $slugRole;
                // exit;
                break;
        }

        return $this->apiResponse($dataService)
            ->send();
    }
}
