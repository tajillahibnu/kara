<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FileUploadService
{
    protected $disk;

    public function __construct($disk = 'public')
    {
        $this->disk = $disk; // Disk default
    }

    /**
     * Upload File
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string|null $fileName
     * @return string File path yang diupload
     */
    public function upload(UploadedFile $file, string $path, ?string $fileName = null): string
    {
        $fileName = $fileName ?? uniqid() . '.' . $file->getClientOriginalExtension();
        return Storage::disk($this->disk)->putFileAs($path, $file, $fileName);
    }

    /**
     * Hapus File
     *
     * @param string $filePath
     * @return bool
     */
    public function delete(string $filePath): bool
    {
        return Storage::disk($this->disk)->delete($filePath);
    }
}
