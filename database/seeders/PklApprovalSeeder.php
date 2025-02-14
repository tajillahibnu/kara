<?php

namespace Database\Seeders;

use App\Models\PklApproval;
use App\Models\PklPeriode;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PklApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ambil ID periode aktif
        $periode = PklPeriode::where('is_active', true)->first();

        if (!$periode) {
            $this->command->warn('Tidak ada periode PKL yang aktif! Seeder tidak dijalankan.');
            return;
        }

        // Ambil role yang sesuai
        $wali_kelas = Role::where('slug', 'wali_kelas')->first();
        $kepala_jurusan = Role::where('slug', 'kepala_jurusan')->first();
        $kepala_program = Role::where('slug', 'kepala_program')->first();
        $kesiswaan = Role::where('slug', 'kesiswaan')->first();

        if (!$wali_kelas || !$kepala_jurusan || !$kepala_program || !$kesiswaan) {
            $this->command->warn('Beberapa role tidak ditemukan. Pastikan RoleSeeder sudah dijalankan.');
            return;
        }

        // Approval untuk jalur Mandiri
        $mandiri_approvals = [
            [
                'periode_id' => $periode->id,
                'role_id' => $wali_kelas->id,
                'is_required' => true,
                'approval_order' => 1,
                'can_override' => false,
                'approval_type' => 'mandiri',
            ],
            [
                'periode_id' => $periode->id,
                'role_id' => $kepala_jurusan->id,
                'is_required' => true,
                'approval_order' => 2,
                'can_override' => false,
                'approval_type' => 'mandiri',
            ],
            [
                'periode_id' => $periode->id,
                'role_id' => $kepala_program->id,
                'is_required' => true,
                'approval_order' => 3,
                'can_override' => false,
                'approval_type' => 'mandiri',
            ],
            [
                'periode_id' => $periode->id,
                'role_id' => $kesiswaan->id,
                'is_required' => true,
                'approval_order' => 4,
                'can_override' => true, // Kesiswaan bisa override jika ada masalah
                'approval_type' => 'mandiri',
            ],
        ];

        // Approval untuk jalur Seleksi
        $seleksi_approvals = [
            [
                'periode_id' => $periode->id,
                'role_id' => $kepala_jurusan->id,
                'is_required' => true,
                'approval_order' => 1,
                'can_override' => false,
                'approval_type' => 'seleksi',
            ],
            [
                'periode_id' => $periode->id,
                'role_id' => $kepala_program->id,
                'is_required' => true,
                'approval_order' => 2,
                'can_override' => false,
                'approval_type' => 'seleksi',
            ],
            [
                'periode_id' => $periode->id,
                'role_id' => $kesiswaan->id,
                'is_required' => true,
                'approval_order' => 3,
                'can_override' => true, // Kesiswaan bisa override jika ada masalah
                'approval_type' => 'seleksi',
            ],
        ];

        // Simpan data approval ke database
        foreach (array_merge($mandiri_approvals, $seleksi_approvals) as $approval) {
            PklApproval::updateOrCreate([
                'periode_id' => $approval['periode_id'],
                'role_id' => $approval['role_id'],
                'approval_type' => $approval['approval_type'],
            ], $approval);
        }

        $this->command->info('Seeder PKL Approval berhasil dijalankan untuk jalur Mandiri dan Seleksi!');
    }
}
