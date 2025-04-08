<?php

namespace Modules\Pkl\Http\Controllers\Pkl;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Pkl\PesertaPklService;

class PesertaPklController extends Controller
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
    public function __construct(PesertaPklService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    /**
     * Mendapatkan data tabel utama.
     *
     * @return mixed Data tabel utama yang diproses oleh service.
     */
    public function mainTable()
    {
        return $this->mainServices->table();
    }
}
