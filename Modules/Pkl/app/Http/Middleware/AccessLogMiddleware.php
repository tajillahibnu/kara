<?php

namespace Modules\Pkl\Http\Middleware;

use App\Models\AccessLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessLogMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request); // Jalankan request ke controller

        // Simpan log akses setelah response diterima
        AccessLog::create([
            'user_id' => auth::user()->id ?? null,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'status_code' => $response->getStatusCode(), // Menyimpan status response
            'metadata' => json_encode([
                'referer' => $request->header('Referer') ?? 'N/A',
                // 'session_id' => session()->getId(),
                // 'request_body' => $request->except(['password', 'token']), // Isi request tanpa data sensitif
                // 'response_body' => $this->getResponseBody($response), // Hasil response
            ]),
            'request_body' => json_encode($request->except(['password', 'token'])),
            'response_body' => json_encode($this->getResponseBody($response)),
        ]);

        return $response;
    }

    // Fungsi untuk mengambil response body (dibatasi agar tidak terlalu besar)
    private function getResponseBody($response)
    {
        $content = $response->getContent();

        // Batasi panjang response untuk menghindari penyimpanan data besar
        return strlen($content) > 5000 ? substr($content, 0, 5000) . '...' : $content;
    }
}
