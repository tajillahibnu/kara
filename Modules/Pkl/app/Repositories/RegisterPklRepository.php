<?php

namespace Modules\Pkl\Repositories;

use App\Models\PklApproval;
use App\Models\PklRegistration;
use App\Models\PklRegistrationStatuses;
use App\Models\Siswa;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class RegisterPklRepository extends BaseRepository
{
    public function __construct(PklRegistration $model)
    {
        parent::__construct($model);
    }

    public function register(array $save, int $id)
    {
        DB::beginTransaction(); // Mulai transaction

        try {

            // Simpan data siswa yang mendaftar PKL
            $siswa = Siswa::find($id);
            if ($siswa) {
                $update['is_pkl'] = true;
                $siswa->update($update);
            }

            // Buat data pendaftaran PKL
            $pklRegistration = PklRegistration::create($save);

            // Ambil approval yang sesuai dengan tipe PKL (Mandiri atau Seleksi)
            $approvals = PklApproval::where('approval_type', $pklRegistration->registration_type) // Bisa 'mandiri' atau 'seleksi'
                // ->where('periode_id', $pklRegistration->periode_id)
                ->orderBy('approval_order', 'asc')
                ->get();

            // Simpan approval ke dalam pkl_registration_statuses
            foreach ($approvals as $approval) {
                PklRegistrationStatuses::create([
                    'siswa_id'      => $id,
                    'jurusan_id'    => $pklRegistration->jurusan_id,
                    'registration_id' => $pklRegistration->id,
                    'role_id'   => $approval->role_id,
                    'status'    => 'pending', // Status awal menunggu konfirmasi
                    'approval_order' => $approval->approval_order,
                ]);
            }
            DB::commit(); // Simpan perubahan ke database

            return $pklRegistration; // Kembalikan data pegawai
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika ada error
            throw $e;
        }
    }
}
