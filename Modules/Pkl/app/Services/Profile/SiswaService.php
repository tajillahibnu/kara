<?php

namespace Modules\Pkl\Services\Profile;

use App\Models\Jurusan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Pkl\Repositories\SiswaRepository;

class SiswaService
{
    protected $repository;

    public function __construct(SiswaRepository $repository)
    {
        /**
         * Memangil Model yang digunakan di repository
         */
        $this->repository = $repository;
    }
    public function getBiodata()
    {
        $biodataId = Auth::user()->biodata_id;
        $getSiswa = Siswa::find($biodataId);
        $dataSiswa = collect(optional($getSiswa)->toArray()); // Semua field Pegawai

        $user = User::with('role')->where('id', Auth::id())->first();

        $jurusanNeme = '';
        if (!empty($getSiswa->jurusan_id)) {
            $jurusan = Jurusan::where('id', $getSiswa->jurusan_id)->first();
            $jurusanNeme = $jurusan->name;
        }
        $dataSiswa = $dataSiswa->merge(['jurusan_name' => $jurusanNeme]);

        // Ubah ke Collection
        $userData = collect(optional($user)->toArray())->only(['username', 'primary_role_id']); // Filter hanya field tertentu dari User

        // Tambahkan name dari role
        $userData->put('role_name', optional($user->role)->name);

        // Gabungkan Data Pegawai dan Data User
        $result = $dataSiswa->merge($userData);

        // Return JSON Response
        return $result;
    }

    public function updateProfile($task, $data)
    {
        $userId = Auth::user()->id;
        $biodatId = Auth::user()->biodata_id;
        $dataToUpdate = [];
        switch ($task) {
            case 'biodata':
                $dataToUpdate['name']   = $data['name'];
                $dataToUpdate['tempat_lahir']   = $data['tempat_lahir'];
                $dataToUpdate['tanggal_lahir']  = date('Y-m-d', strtotime($data['tanggal_lahir']));
                $dataToUpdate['no_wa']  = $data['no_wa'];
                $dataToUpdate['email']  = $data['email'];
                $dataToUpdate = $this->repository->siswaToUpdate($dataToUpdate, $biodatId, function ($response) use ($userId) {
                    try {
                        $userToUpdate = [
                            'name'  => $response['name'],
                            'email' => $response['email'] // Kesalahan disini
                        ];
                        User::where('id', $userId)->update($userToUpdate);
                    } catch (\Exception $e) {
                        // Tangkap error dan ubah pesan error sebelum dilempar ke controller
                        throw new \Exception("Gagal memperbarui user: Pastikan kolom yang diperbarui benar.");
                    }
                });
                break;
            default:
                # code...
                break;
        }
        return $dataToUpdate;
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
