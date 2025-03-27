<?php

namespace Modules\Pkl\Repositories;

use App\Models\PklRegistration;
use App\Models\PklRegistrationStatuses;
use App\Models\Siswa;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProsesRegistrasiPklRepository extends BaseRepository
{
    public function __construct(PklRegistration $model)
    {
        parent::__construct($model);
    }

    /**
     * Fungsi utama untuk approval berdasarkan kondisi tertentu
     */
    private function updateRegistrationStatus($registerId, $status, $roleFilter = true)
    {
        return DB::transaction(function () use ($registerId, $status, $roleFilter) {
            // **Pastikan action hanya 'completed' atau 'rejected'**
            if (!in_array($status, ['completed', 'rejected'])) {
                throw new \InvalidArgumentException("Action must be 'completed' or 'rejected'");
            }

            // Ambil query untuk update status berdasarkan role pengguna jika diperlukan
            $query = PklRegistrationStatuses::where('registration_id', $registerId)
                ->where('status', 'pending');

            if ($roleFilter) {
                $role_id = Auth::user()->id;
                $query->where('role_id', $role_id);
            }

            // Update status menjadi 'completed' atau 'rejected'
            $update['user_id']  = Auth::user()->id;
            $update['status']   = $status;
            $update['status_updated_at'] = now();

            $updatedStatus = tap($query)->update($update)->get();

            // Ambil data register yang terkait
            $updatedRegister = PklRegistration::where('id', $registerId)->first();

            if (!$updatedRegister) {
                throw new \Exception("PklRegistration dengan ID $registerId tidak ditemukan.");
            }

            if ($status === 'completed') {
                // Cek apakah semua approval sudah diberikan
                $countPending = PklRegistrationStatuses::where('registration_id', $registerId)
                    ->where('status', '!=', 'completed')
                    ->count();

                // Jika semua sudah disetujui, update status utama di `PklRegistration`
                if ($countPending == 0) {
                    $updatedRegister->update([
                        'status_register' => 'completed',
                        'status_updated_at' => now(),
                    ]);
                }
            } elseif ($status === 'rejected') {
                // Jika direject, ubah `is_pkl` menjadi false untuk siswa terkait
                Siswa::where('id', $updatedRegister->siswa_id)
                    ->update(['is_pkl' => false]);

                // Update status di tabel `PklRegistration`
                $updatedRegister->update([
                    'status_register' => 'rejected',
                    'status_updated_at' => now(),
                ]);
            }

            return [
                'status_updates' => $updatedStatus,
                'register_update' => $updatedRegister
            ];
        });
    }



    /**
     * Approve berdasarkan role pengguna
     */
    public function saveAcc($registerId)
    {
        return $this->updateRegistrationStatus($registerId, 'completed', true);
    }

    /**
     * Approve semua tanpa melihat role
     */
    public function saveAccAll($registerId)
    {
        return $this->updateRegistrationStatus($registerId, 'completed', false);
    }


    public function saveReject($registerId)
    {
        return $this->updateRegistrationStatus($registerId, 'completed', true);
    }
    public function saveRejectAll($registerId)
    {
        return $this->updateRegistrationStatus($registerId, 'completed', false);
    }
}
