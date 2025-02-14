<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super_admin', 'description' => 'Full access to the system'],
            ['name' => 'Admin Sekolah', 'slug' => 'admin_sekolah', 'description' => 'Manage school operations'],
            ['name' => 'Guru', 'slug' => 'guru', 'description' => 'Manage student grades and attendance'],
            ['name' => 'Siswa', 'slug' => 'siswa', 'description' => 'View academic information'],
            ['name' => 'Orang Tua', 'slug' => 'orang_tua', 'description' => 'Monitor student progress'],
            ['name' => 'Staff TU', 'slug' => 'staff_tu', 'description' => 'Manage administrative documents'],
            ['name' => 'Staff', 'slug' => 'staff', 'description' => 'Manage administrative documents'],
            ['name' => 'Karyawan', 'slug' => 'karyawan', 'description' => 'Manage administrative documents'],

            // Tambahan role khusus approval PKL
            ['name' => 'Wali Kelas', 'slug' => 'wali_kelas', 'description' => 'Approve PKL for Mandiri track'],
            ['name' => 'Kepala Jurusan', 'slug' => 'kepala_jurusan', 'description' => 'Approve PKL for Mandiri & Seleksi'],
            ['name' => 'Kepala Program', 'slug' => 'kepala_program', 'description' => 'Approve PKL for Mandiri & Seleksi'],
            ['name' => 'Kesiswaan', 'slug' => 'kesiswaan', 'description' => 'Final approval for PKL registration'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
