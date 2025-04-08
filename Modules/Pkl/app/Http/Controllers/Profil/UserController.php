<?php

namespace Modules\Pkl\Http\Controllers\Profil;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FileUploadService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Pkl\Services\Alamat\AlamatPegawaiService;
use Modules\Pkl\Services\Alamat\AlamatSiswaService;
use Modules\Pkl\Services\Profile\GuruService;
use Modules\Pkl\Services\Profile\IdukaService;
use Modules\Pkl\Services\Profile\SiswaService;

class UserController extends Controller
{
    use ApiResponseTrait;

    protected FileUploadService $fileUploadService;
    protected $guruService;
    protected $siswaService;
    protected $idukaService;
    protected $alamatSiswaService;
    protected $alamatPegawaiService;

    public function __construct(
        FileUploadService $fileUploadService,
        GuruService $guruService,
        SiswaService $siswaService,
        IdukaService $idukaService,
        AlamatSiswaService $alamatSiswaService,
        AlamatPegawaiService $alamatPegawaiService,
    ) {
        $this->fileUploadService = $fileUploadService;
        $this->guruService = $guruService;
        $this->siswaService = $siswaService;
        $this->alamatSiswaService   = $alamatSiswaService;
        $this->alamatPegawaiService = $alamatPegawaiService;
        $this->idukaService = $idukaService;
    }

    public function info(Request $request)
    {
        $bIsSiswa = Auth::user()->is_siswa;
        $aArrData = [];
        $task = $request->input('task');
        if ($bIsSiswa) {
            switch ($task) {
                case 'alamat':
                    $aArrData = $this->alamatSiswaService->fetchAlamat(Auth::user()->biodata_id);
                    break;
                default:
                    $aArrData = $this->siswaService->getBiodata();
                    break;
            }
        } else {
            $getUser = User::with('role')->where('id', Auth::id())->first();
            if ($getUser->role->slug == 'iduka') {
                $aArrData = $this->idukaService->getBiodata();
            } else {
                switch ($task) {
                    case 'alamat':
                        $aArrData = $this->alamatPegawaiService->fetchAlamat(Auth::user()->biodata_id);
                        break;
                    default:
                        $aArrData = $this->guruService->getBiodata();
                        break;
                }
            }
        }
        return $this->apiResponse($aArrData)
            ->send();
    }

    public function update(Request $request)
    {
        $aArrData = [];
        try {
            $bIsSiswa = Auth::user()->is_siswa;
            $task = $request->input('task');
            if ($bIsSiswa) {
                if ($task == 'alamat') {
                    $taskId = !empty($request->input('taskID')) ? $request->input('taskID') : null;
                    $aArrData = $this->alamatSiswaService->save($request->input(), Auth::user()->biodata_id, $taskId);
                } else if ($task == 'delete') {
                    $aArrData = $this->alamatSiswaService->delete($request->input('id'), Auth::user()->biodata_id);
                } else if ($task == 'password') {
                    $aArrData = $this->siswaService->changePassword($request->input(), Auth::user()->id);
                } else {
                    $aArrData = $this->siswaService->updateProfile($task, $request->input());
                }
            } else {
                $getUser = User::with('role')->where('id', Auth::id())->first();
                if ($getUser->role->slug == 'iduka') {
                    $aArrData = $this->idukaService->save($task, $request->input());
                } else {
                    if ($task == 'alamat') {
                        $taskId = !empty($request->input('taskID')) ? $request->input('taskID') : null;
                        $aArrData = $this->alamatPegawaiService->storeUpdate($request->input(), Auth::user()->biodata_id, $taskId);
                    } else if ($task == 'delete') {
                        $aArrData = $this->alamatPegawaiService->delete($request->input('id'), Auth::user()->biodata_id);
                    } else if ($task == 'password') {
                        $aArrData = $this->guruService->changePassword($request->input(), Auth::user()->id);
                    } else {
                        $aArrData = $this->guruService->save($task, $request->input());
                    }
                }
            }

            return $this->apiResponse($aArrData)
                ->send();
        } catch (\Exception $e) {
            return $this->apiResponse([])
                ->statusCode(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    public function doUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'disk' => 'in:local,s3',  // Validasi disk
        ]);

        try {
            $file = $request->file('file');
            $disk = $request->input('disk', 's3');  // Default ke local kalau tidak dipilih
            $url = $this->fileUploadService->upload($file, 'pkl_files', $disk);

            return response()->json([
                'status' => 'success',
                'message' => 'File berhasil di-upload.',
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
