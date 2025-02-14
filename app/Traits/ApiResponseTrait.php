<?php

namespace App\Traits;

use Exception;

trait ApiResponseTrait
{
    protected $response = [];
    protected $statusCode = 200;

    // Pesan default untuk sukses dan error
    protected $defaultSuccessMessage = 'Request berhasil diproses';
    protected $defaultErrorMessage = 'Terjadi kesalahan pada server';

    /**
     * Atur data awal untuk API response.
     *
     * @param mixed $data
     * @return self
     */
    public function apiResponse($data = null)
    {
        // Jika ada statusCode atau message di data, atur ke response dan hapus dari data utama
        if (is_array($data)) {
            if (isset($data['statusCode'])) {
                $this->statusCode = $data['statusCode'];
                unset($data['statusCode']);
            }

            if (isset($data['message'])) {
                $this->response['message'] = $data['message'];
                unset($data['message']);
            }
        }

        // Jika tidak ada pesan, set pesan default berdasarkan statusCode
        if (!isset($this->response['message'])) {
            $this->response['message'] = $this->statusCode >= 200 && $this->statusCode < 300
                ? $this->defaultSuccessMessage
                : $this->defaultErrorMessage;
        }

        // Atur data ke response
        $this->response['data'] = $this->sanitizeResponseData($data);

        // Set success dan status berdasarkan statusCode
        $this->response['success'] = $this->statusCode >= 200 && $this->statusCode < 300;
        $this->response['status'] = $this->statusCode >= 200 && $this->statusCode < 300 ? 'success' : 'error';

        return $this;
    }

    /**
     * Tambahkan pesan ke respons.
     *
     * @param string $message
     * @return self
     */
    public function message(string $message)
    {
        $this->response['message'] = $message;
        return $this;
    }

    /**
     * Tambahkan detail error jika ada.
     *
     * @param mixed $errors
     * @return self
     */
    public function errors($errors)
    {
        $this->response['errors'] = $errors;
        $this->response['success'] = false; // Set success ke false jika ada errors
        $this->response['status'] = 'error';
        return $this;
    }

    /**
     * Atur status kode HTTP.
     *
     * @param int $code
     * @return self
     */
    public function statusCode(int $code)
    {
        $this->statusCode = $code;

        // Tentukan success dan status berdasarkan kode
        $this->response['success'] = $code >= 200 && $code < 300;
        $this->response['status'] = $code >= 200 && $code < 300 ? 'success' : 'error';

        return $this;
    }

    /**
     * Kirim respons sebagai JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send()
    {
        return response()->json($this->response, $this->statusCode);
    }

    /**
     * Sanitasi data respons untuk menghindari struktur ['data']['data'].
     *
     * @param mixed $data
     * @return mixed
     */
    protected function sanitizeResponseData($data)
    {
        if (is_array($data) && isset($data['data']) && is_array($data['data'])) {
            return $data['data']; // Ambil data dalamnya
        }

        return $data;
    }

    /**
     * Tangani exception dan format respons error.
     *
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleException(Exception $e)
    {
        $this->response = [
            'success' => false,
            'status' => 'error',
            'message' => $e->getMessage() ?: $this->defaultErrorMessage,
            'errors' => $e->getTrace(), // Opsional: Tambahkan trace untuk debugging
        ];

        $this->statusCode = $e->getCode() >= 100 && $e->getCode() < 600 ? $e->getCode() : 500;

        return $this->send();
    }
}
