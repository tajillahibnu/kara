<?php

namespace Modules\Pkl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Dashboard\DashboardSiswaService;
use Modules\Pkl\Services\Dashboard\SuperadminService;

class DashboardController extends Controller
{
    use ApiResponseTrait;
    protected $superadminServices;
    protected $dashboardSiswaService;
    public function __construct(
        SuperadminService $superadminServices,
        DashboardSiswaService $dashboardSiswaService,

        )
    {
        $this->superadminServices = $superadminServices;
        $this->dashboardSiswaService = $dashboardSiswaService;
    }

    public function show()
    {
        $slugRole = session('active_role_slug');
        switch ($slugRole) {
            case 'super_admin':
            case 'admin_sekolah':
                $dataService = $this->superadminServices->info();
                break;
            case 'siswa':
                $dataService = $this->dashboardSiswaService->getBiodata();
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
