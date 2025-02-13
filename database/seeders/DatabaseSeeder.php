<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\PeriodePkl;
use App\Models\Role;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\StatusKelas;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            TahunAkademikSeeder::class,
            TingkatSeeder::class,
            ConfigAppSeeder::class,
            RoleSeeder::class,
            MenuSeeder::class,
            PegawaiSeeder::class,
            StatusKelasSeeder::class,
        ]);
        
        $this->create_user();
        
        $this->call([
            JurusanSeeder::class,
            RombelSeeder::class,
            DudiSeeder::class,
            SiswaSeeder::class,
            PklPeriodeSeeder::class,
        ]);
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

    private function create_user()
    {
        // User::factory(10)->create();
        $superadmin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@demo.com',
            'username' => 'admin',
            'primary_role_id' => 1,
            'is_siswa' => false,
            'is_active' => true,
        ]);

        // Buat atau ambil role, lalu attach ke setiap user
        $roleIds = Role::all()
            ->pluck('id')
            ->all();

        $superadmin->each(function ($item) use ($roleIds) {
            foreach ($roleIds as $roleId) {
                $rolesWithPivot[$roleId] = [
                    'is_primary' => $item->primary_role_id == $roleId,
                ];
            }

            $item->roles()->attach($rolesWithPivot);
        });

        // Buat siswa
        // User::factory()->siswa()->count(10)->create();

        // Buat karyawan
        // User::factory()->karyawan()->count(10)->create();


        // // Buat 10 user karyawan
        // $users = User::factory()->karyawan()->count(5)->create();
        // // Definisikan role yang dibutuhkan
        // $roles = [
        //     'staff_tu',
        //     'guru',
        // ];
        // // Buat atau ambil role, lalu attach ke setiap user
        // $roleIds = Role::whereIn('slug', $roles)
        //     ->pluck('id')
        //     ->all();

        // $users->each(function ($user) use ($roleIds) {
        //     $rolesWithPivot = [];

        //     foreach ($roleIds as $roleId) {
        //         $rolesWithPivot[$roleId] = [
        //             'is_primary' => $user->primary_role_id == $roleId,
        //         ];
        //     }

        //     $user->roles()->attach($rolesWithPivot);
        // });
    }
}
