<?php

namespace Database\Seeders;

use App\Models\Dudi;
use App\Models\DudiChekInOut;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat Dudi beserta DudiRule menggunakan factory
        Dudi::factory()
            ->count(5) // Membuat 5 Dudi
            ->create()
            ->each(function ($dudi) {
                $dudi->rules()->createMany([
                    ['rule_type' => 'max_siswa_motor', 'value' => 5],
                    ['rule_type' => 'max_siswa_perempuan', 'value' => 3],
                ]);
            });

        Dudi::create([
            'name' => 'PT. Software Indonesia',
            'address' => 'Jl. Teknologi No. 12, Jakarta',
            'phone' => '021-123456',
            'email' => 'info@softwareindonesia.com',
            'website' => 'https://softwareindonesia.com',
            'latitude' => -6.200000,
            'longitude' => 106.816666,
            'pic_name' => 'Budi Santoso',
            'pic_jabatan' => 'Kepala Bagian',
            'pic_phone' => '08123456789',
            'quota' => 10,
            'sector' => 'Teknologi Informasi',
            'partnership_status' => 'Mitra Tetap',
            'description' => 'Perusahaan pengembang software dengan fokus pada aplikasi berbasis web dan mobile.',
            'requirements' => 'Siswa harus memiliki pemahaman dasar tentang pemrograman.',
            'is_active' => true,
            'username' => 'dudi1',
            'password' => 'password@123',
        ]);

        Dudi::create([
            'name' => 'Bengkel Motor Jaya',
            'address' => 'Jl. Otomotif No. 45, Bandung',
            'phone' => '022-7654321',
            'email' => 'bengkel@motorshop.com',
            'website' => null,
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'pic_name' => 'Ahmad Jun',
            'pic_jabatan' => 'Kepala Devisi',
            'pic_phone' => '08129876543',
            'quota' => 5,
            'sector' => 'Otomotif',
            'partnership_status' => 'Belum Ada MoU',
            'description' => 'Bengkel yang melayani perawatan dan perbaikan motor.',
            'requirements' => 'Siswa diutamakan yang memiliki dasar mekanik otomotif.',
            'is_active' => true,
            'username' => 'dudi2',
            'password' => 'password@123',
        ]);

        Dudi::create([
            'name' => 'PT.Dirgantara',
            'address' => 'Jl. Otomotif No. 45, Bandung',
            'phone' => '022-7654321',
            'email' => 'bengkel1@motorshop.com',
            'website' => null,
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'pic_name' => 'Karlina',
            'pic_jabatan' => 'Manager',
            'pic_phone' => '08129876543',
            'quota' => 5,
            'sector' => 'Otomotif',
            'partnership_status' => 'Belum Ada MoU',
            'description' => 'Bengkel yang melayani perawatan dan perbaikan motor.',
            'requirements' => 'Siswa diutamakan yang memiliki dasar mekanik otomotif.',
            'is_active' => true,
            'username' => 'dudi3',
            'password' => 'password@123',
        ]);

        Dudi::create([
            'name' => 'PT.Indo Jaya',
            'address' => 'Jl. Otomotif No. 45, Bandung',
            'phone' => '022-7654321',
            'email' => 'bengkel2@motorshop.com',
            'website' => null,
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'pic_name' => 'Sutris',
            'pic_jabatan' => 'HRD',
            'pic_phone' => '08129876543',
            'quota' => 5,
            'sector' => 'Otomotif',
            'partnership_status' => 'Belum Ada MoU',
            'description' => 'Bengkel yang melayani perawatan dan perbaikan motor.',
            'requirements' => 'Siswa diutamakan yang memiliki dasar mekanik otomotif.',
            'is_active' => true,
            'username' => 'dudi4',
            'password' => 'password@123',
        ]);
        $this->attendance();
    }

    private function attendance()
    {
        $aArrData = Dudi::all();
        $getRole = Role::where('slug', 'iduka')->first();
        foreach ($aArrData as $key => $value) {
            $save['dudi_id'] = $value->id;
            for ($i = 1; $i <= 7; $i++) {
                $daySlug = strtolower(Carbon::create(2024, 1, $i)->format('l')); // "Monday", "Tuesday", etc.

                $save['shift'] = 'umum';
                $save['day_number'] = $i;
                $save['day_slug'] = $daySlug;
                $save['clock_in'] = '08:00:00';
                $save['clock_out'] = '17:00:00';
                $save['ramadhan_clock_in'] = '08:00:00';
                $save['ramadhan_clock_out'] = '16:00:00';
                DudiChekInOut::create($save);
            }
            $user = User::create([
                'name'       => $value->name,
                'username'   => $value->username ?? 'dudi'.$key, // Gunakan username yang sudah dibuat
                'email'      => $value->email,
                'password'   => Hash::make($value->password ?? 'password@123'), // Bisa pakai default password atau dari request
                'biodata_id' => $value->id,
                'is_siswa'          => false,
                'primary_role_id'   => $getRole->id,
            ]);
        }
    }
}
