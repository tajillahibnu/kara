<?php

namespace Modules\Pkl\Http\Controllers\Jurnal;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Pkl\Services\Jurnal\KegiatanService;
use Illuminate\Validation\ValidationException;

class KegiatanController extends Controller
{
    use ApiResponseTrait;
    protected $mainServices;
    public function __construct(KegiatanService $mainServices)
    {
        $this->mainServices = $mainServices;
    }

    public function store(Request $request)
    {
        try {
            $data = $this->mainServices->store($request->all());
            return $this->apiResponse($data)->send();
        } catch (ValidationException $e) {
            return $this->apiResponse()
                ->errors($e->errors())
                ->statusCode(422)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction. ' . $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $this->mainServices->update($id, $request->all());
            return $this->apiResponse($data)->send();
        } catch (ValidationException $e) {
            return $this->apiResponse()
                ->errors($e->errors())
                ->statusCode(422)
                ->send();
        } catch (\Throwable $th) {
            throw new Exception('Internal server malfunction. ' . $th->getMessage());
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
        $slugRole = session('active_role_slug');
        return $this->mainServices->table($slugRole);
    }
}
