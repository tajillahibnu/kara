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
        Role::create(['name' => 'Super Admin', 'slug' => 'super_admin', 'description' => 'Full access to the system']);
        Role::create(['name' => 'Admin Sekolah', 'slug' => 'admin_sekolah', 'description' => 'Manage school operations']);
        Role::create(['name' => 'Guru', 'slug' => 'guru', 'description' => 'Manage student grades and attendance']);
        Role::create(['name' => 'Siswa', 'slug' => 'siswa', 'description' => 'View academic information']);
        Role::create(['name' => 'Orang Tua', 'slug' => 'orang_tua', 'description' => 'Monitor student progress']);
        Role::create(['name' => 'Staff TU', 'slug' => 'staff_tu', 'description' => 'Manage administrative documents']);
        Role::create(['name' => 'Staff', 'slug' => 'staff', 'description' => 'Manage administrative documents']);
        Role::create(['name' => 'Karyawan', 'slug' => 'karyawan', 'description' => 'Manage administrative documents']);
    }
}
