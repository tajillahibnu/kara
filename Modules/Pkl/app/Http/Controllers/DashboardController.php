<?php

namespace Modules\Pkl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Modules\Pkl\Services\Dashboard\DashboardSiswaService;
use Modules\Pkl\Services\Dashboard\GuruService;
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
    protected $guruServices;

    protected $roleServices = [
        'super_admin' => ['service' => 'superadminServices', 'method' => 'info'],
        'admin_sekolah' => ['service' => 'superadminServices', 'method' => 'info'],
        'siswa' => ['service' => 'dashboardSiswaService', 'method' => 'getBiodata'],
        'iduka' => ['service' => 'idukaDashboardService', 'method' => 'readDashboard'],
        'wali_kelas' => ['service' => 'walikelasDashboardService', 'method' => 'readDashboard'],
        'kepala_jurusan' => ['service' => 'kakomliServices', 'method' => 'readDashboard'],
        'guru' => ['service' => 'guruServices', 'method' => 'readDashboard'],
    ];

    public function __construct(
        SuperadminService $superadminServices,
        DashboardSiswaService $dashboardSiswaService,
        IdukaService $idukaDashboardService,
        WaliKelasService $walikelasDashboardService,
        KakomliService $kakomliServices,
        GuruService $guruServices,
    ) {
        $this->superadminServices = $superadminServices;
        $this->dashboardSiswaService = $dashboardSiswaService;
        $this->idukaDashboardService = $idukaDashboardService;
        $this->walikelasDashboardService = $walikelasDashboardService;
        $this->kakomliServices = $kakomliServices;
        $this->guruServices = $guruServices;
    }

    public function show()
    {
        $slugRole = session('active_role_slug');

        // Cek apakah role ada di array $roleServices
        if (isset($this->roleServices[$slugRole])) {
            $serviceName = $this->roleServices[$slugRole]['service'];
            $methodName = $this->roleServices[$slugRole]['method'];

            // Pastikan method ada di service
            if (method_exists($this->{$serviceName}, $methodName)) {
                $dataService = $this->{$serviceName}->{$methodName}();
            } else {
                return $this->apiResponse("Method $methodName tidak ditemukan di $serviceName")->failed();
            }
        } else {
            $dataService = ['message' => 'Role tidak dikenali', 'role' => $slugRole];
        }

        return $this->apiResponse($dataService)->send();
    }
}
