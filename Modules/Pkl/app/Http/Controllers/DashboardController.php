<?php

namespace Modules\Pkl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Dashboard\DashboardSiswaService;
use Modules\Pkl\Services\Dashboard\IdukaService;
use Modules\Pkl\Services\Dashboard\KakomliService;
use Modules\Pkl\Services\Dashboard\SuperadminService;
use Modules\Pkl\Services\Dashboard\WaliKelasService;

class DashboardController extends Controller
{
    use ApiResponseTrait;
    protected $superadminServices;
    protected $dashboardSiswaService;
    protected $idukaDashboardService;
    protected $walikelasDashboardService;
    protected $kakomliServices;
    public function __construct(
        SuperadminService $superadminServices,
        DashboardSiswaService $dashboardSiswaService,
        IdukaService $idukaDashboardService,
        WaliKelasService $walikelasDashboardService,
        KakomliService $kakomliServices,

    ) {
        $this->superadminServices = $superadminServices;
        $this->dashboardSiswaService = $dashboardSiswaService;
        $this->idukaDashboardService = $idukaDashboardService;
        $this->walikelasDashboardService = $walikelasDashboardService;
        $this->kakomliServices = $kakomliServices;
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
            case 'iduka':
                $dataService = $this->idukaDashboardService->readDashboard();
                break;
            case 'iduka':
                $dataService = $this->idukaDashboardService->readDashboard();
                break;
            case 'wali_kelas':
                $dataService = $this->walikelasDashboardService->readDashboard();
                break;
            case 'kepala_jurusan':
                $dataService = $this->kakomliServices->readDashboard();
                break;
            default:
                # code...
                $dataService[] = $slugRole;
                // exit;
                break;
        }

        return $this->apiResponse($dataService)
            ->send();
    }
}
