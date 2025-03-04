<?php

namespace Modules\Pkl\Http\Controllers\Profil;

use App\Http\Controllers\Controller;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
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
