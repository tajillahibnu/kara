<?php

namespace Modules\Pkl\Services\Upload;

use App\Models\Jurusan;
use App\Models\Upload_siswa;
use App\Services\DataTableService;
use Illuminate\Support\Facades\Storage;
use Modules\Pkl\Jobs\ProcessSiswaUploade;

class SiswaFileService
{
    public function uploadSiswaJurusan($request)
    {
        $file = $request->file('files_siswa');
        $filename = time();
        $location = 'uploads/siswa/';
        Storage::disk('s3')->put($location . $filename, file_get_contents($file));

        $upload = Upload_siswa::create([
            'filename' => $filename,
            'path'      => $location,
            'original_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'url' => Storage::disk('s3')->url($location . $filename),
            'status' => 'pending',
            'jurusan_id' => $request->input('jurusan_id')
        ]);

        // Kirim ke queue untuk diproses
        dispatch(new ProcessSiswaUploade($upload));

        return [
            'message' => 'File berhasil diupload dan sedang diproses',
            'data' => $upload
        ];
    }

    public function tableSiswa($request)
    {
        $file_id = $request->input('id');
        return DataTableService::draw('temp_siswas')
            ->where('deleted_at', null)
            ->where('upload_siswa_id', $file_id)
            ->addColumn('action', function ($detail) {
                return '
                <div class="d-inline-block">
                    <a href="javascript:void(0);" class="btn btn-sm rounded-pill btn-icon dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true"><i class="ti ti-dots-vertical ti-md"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" data-popper-placement="bottom-end">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="upload-siswa-detail" onclick="editSiswa(this)" data-params="' . base64_encode(json_encode($detail)) . '">Edit</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="upload-siswa-detail" onclick="deleteSiswa(this)" data-params="' . base64_encode(json_encode($detail)) . '">Delete</a>
                        </li>
                    </ul>
                </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    public function table()
    {
        return DataTableService::draw('upload_siswas')
            ->select(['upload_siswas.*', 'jurusans.name AS jurusan_name'])
            ->join('jurusans', [
                ['jurusans.id', '=', 'upload_siswas.jurusan_id'],
            ])
            ->where('upload_siswas.deleted_at', null)
            ->addColumn('status', function ($detail) {
                switch ($detail->status) {
                    case 'pending':
                        $badgeClass = 'bg-label-warning';
                        break;
                    case 'failed':
                        $badgeClass = 'bg-label-danger';
                        break;
                    case 'completed':
                        $badgeClass = 'bg-label-success';
                        break;
                    default:
                        $badgeClass = 'bg-label-secondary';
                }

                $badgeText = ucfirst($detail->status); // Huruf pertama kapital

                return '<span class="badge ' . $badgeClass . '">' . htmlspecialchars($badgeText) . '</span>';
            })
            ->addColumn('action', function ($detail) {
                return '
                <div class="d-inline-block">
                    <a href="javascript:void(0);" class="btn btn-sm rounded-pill btn-icon dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true"><i class="ti ti-dots-vertical ti-md"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" data-popper-placement="bottom-end">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="upload-siswa-detail" onclick="onDetails(this)" data-params="' . base64_encode(json_encode($detail)) . '">Detail</a>
                        </li>
                    </ul>
                </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }
}
