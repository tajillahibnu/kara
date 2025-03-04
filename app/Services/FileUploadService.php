<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FileUploadService
{
    /**
     * Upload file dengan disk yang dipilih.
     * 
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $disk Pilihan disk: local atau minio
     * @return string URL file yang di-upload
     * @throws Exception
     */
    public function upload($file, $path = 'pkl_files', $disk = null)
    {
        try {
            // Tentukan disk, default ke S3 atau dari .env
            $disk = $disk ?? env('FILESYSTEM_DISK', 's3');

            // Bikin path unik buat file
            $filePath = $path . '/' . uniqid() . '-' . $file->getClientOriginalName();

            // Upload file ke disk yang dipilih
            Storage::disk($disk)->put($filePath, file_get_contents($file));

            // Generate URL tergantung disk
            if ($disk === 's3') {
                // URL buat S3 atau MinIO
                $url = env('AWS_ENDPOINT') . '/' . env('AWS_BUCKET') . '/' . $filePath;
                // Benerin URL kalau MinIO lokal
                $url = str_replace('http://minio:9000', 'http://localhost:9000', $url);
            } else {
                // URL buat lokal
                $url = asset('storage/' . $filePath);
            }

            return $url;
        } catch (\Exception $e) {
            // Log error kalau ada masalah
            // \Log::error('Upload Error: ' . $e->getMessage());
            return null;
        }
    }
}
