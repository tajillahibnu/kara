<?php

namespace Modules\Pkl\Services\Profile;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Pkl\Repositories\PegawaiRepository;

class GuruService
{
    protected $repository;

    public function __construct(PegawaiRepository $repository)
    {
        /**
         * Memangil Model yang digunakan di repository
         */
        $this->repository = $repository;
    }

    public function getBiodata()
    {
        $biodataId = Auth::user()->biodata_id;

        // Ambil seluruh data Pegawai
        $pegawai = Pegawai::find($biodataId);

        // Ambil data User dengan filter field tertentu
        // $user = User::where('id', Auth::id())->first();
        // Ambil User dengan relasi Role
        $user = User::with('role')->where('id', Auth::id())->first();


        // Ubah ke Collection
        $pegawaiData = collect(optional($pegawai)->toArray()); // Semua field Pegawai
        $userData = collect(optional($user)->toArray())->only(['username', 'primary_role_id']); // Filter hanya field tertentu dari User

        // Tambahkan name dari role
        $userData->put('role_name', optional($user->role)->name);

        // Gabungkan Data Pegawai dan Data User
        $result = $pegawaiData->merge($userData);

        // Return JSON Response
        return $result;
    }


    public function save($task, $data)
    {
        $userId = Auth::user()->id;
        $biodatId = Auth::user()->biodata_id;
        switch ($task) {
            case 'biodata':
                $dataToUpdate = $this->prepareData($data);
                $this->repository->pegawaiToUpdate($dataToUpdate, $biodatId, function ($response) use ($userId) {
                    try {
                        // Simulasi error: "emailz" tidak ada di database
                        $userToUpdate = [
                            'email' => $response['email'] // Kesalahan disini
                        ];
                        User::where('id', $userId)->update($userToUpdate);
                    } catch (\Exception $e) {
                        // Tangkap error dan ubah pesan error sebelum dilempar ke controller
                        throw new \Exception("Gagal memperbarui user: Pastikan kolom yang diperbarui benar.");
                    }
                });
                break;
            case 'akun_app':
                if (!empty($data['password'])) {
                    $dataToUpdate['password'] = Hash::make($data['password']);
                }
                $userToUpdate['username'] = $data['username'];
                $dataToUpdate = User::where('id', $userId)->update($userToUpdate);
                break;
            default:
                $dataToUpdate = [];
                break;
        }
        return $dataToUpdate;
    }

    protected function prepareData(array $input)
    {
        $data = [
            'nik'       => $input['nik'] ?? null,
            'name'      => $input['name'] ?? null,
            'tempat_lahir'    => $input['tempat_lahir'] ?? null,
            'tanggal_lahir'   => date('Y-m-d', strtotime($input['tanggal_lahir'])) ?? null,
            'email'     => $input['email'] ?? null,
            'alamat'    => $input['alamat'] ?? null,
        ];
        return $data;
    }

    public function changePassword(array $input, $userId)
    {
        // Update password
        $user = User::findOrFail($userId);
        $user->password = Hash::make($input['newPassword']);
        $user->save();
        return $user;
    }
}
