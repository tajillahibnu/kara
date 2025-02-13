<?php
// app/helpers.php

use Illuminate\Support\Facades\Cache;

if (!function_exists('encryptData')) {
    function encryptData($data)
    {
        // Menggunakan base64_encode
        return base64_encode($data);

        // Jika ingin menggunakan Laravel Crypt
        // return Crypt::encryptString($data);
    }
}

if (!function_exists('decryptData')) {
    function decryptData($data)
    {
        // Menggunakan base64_decode
        return base64_decode($data);

        // Jika ingin menggunakan Laravel Crypt
        // return Crypt::decryptString($data);
    }
}

if (!function_exists('getSiteMeta')) {
    function getSiteMeta()
    {
        if (env('APP_ENV') === 'local') {
            // Ambil data dari database untuk mode development
            $data = \App\Models\ConfigApp::all();
            $filteredData = $data->filter(function ($item) {
                return !$item->is_sensitive; // Pastikan ada kolom 'is_sensitive' pada tabel
            });
            return $filteredData->groupBy('config_tipe')
                ->mapWithKeys(function ($group, $type) {
                    return [
                        $type => $group->pluck('config_value', 'config_name')->toArray()
                    ];
                })->toArray();
        }

        // Gunakan cache untuk mode produksi
        return Cache::remember('site_meta', 60 * 60 * 24, function () {
            $data = \App\Models\ConfigApp::all();
            $filteredData = $data->filter(function ($item) {
                return !$item->is_sensitive; // Pastikan ada kolom 'is_sensitive' pada tabel
            });
            return $filteredData->groupBy('config_tipe')
                ->mapWithKeys(function ($group, $type) {
                    return [
                        $type => $group->pluck('config_value', 'config_name')->toArray()
                    ];
                })->toArray();
        });
    }
}
