<?php

namespace Modules\Pkl\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Master\RombelService;

class RombelController extends Controller
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
    public function __construct(RombelService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    /**
     * Menyimpan data baru.
     *
     * @param Request $request Data permintaan yang berisi input untuk disimpan.
     * @return \Illuminate\Http\JsonResponse Response API dengan status operasi.
     * @throws Exception Jika terjadi kesalahan server.
     */
    public function store(Request $request)
    {
        try {
            $aArrStore = $this->mainServices->store($request->input());
            return $this->apiResponse($aArrStore)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.'.$th->getMessage());
        }
    }

    /**
     * Memperbarui data berdasarkan ID.
     *
     * @param Request $request Data permintaan yang berisi input untuk diperbarui.
     * @param int $id ID dari data yang akan diperbarui.
     * @return \Illuminate\Http\JsonResponse Response API dengan status operasi.
     * @throws Exception Jika terjadi kesalahan server.
     */
    public function update(Request $request, $id)
    {
        try {
            $aArrUpdate = $this->mainServices->update($id, $request->input());
            return $this->apiResponse($aArrUpdate)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.'.$th->getMessage());
        }
    }

    /**
     * Memperbarui data berdasarkan ID.
     *
     * @param Request $request Data permintaan yang berisi input untuk diperbarui.
     * @param int $id ID dari data yang akan diperbarui.
     * @return \Illuminate\Http\JsonResponse Response API dengan status operasi.
     * @throws Exception Jika terjadi kesalahan server.
     */
    public function status(Request $request)
    {
        try {
            $id = $request->input('id');
            $aArrInput = $request->input('data');
            $aArrUpdate = $this->mainServices->status($id, $aArrInput);
            return $this->apiResponse($aArrUpdate)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction.');
        }
    }

    /**
     * Menghapus data berdasarkan ID.
     *
     * @param Request $request Data permintaan yang berisi ID data yang akan dihapus.
     * @return \Illuminate\Http\JsonResponse Response API dengan status operasi.
     * @throws Exception Jika terjadi kesalahan server.
     */
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
