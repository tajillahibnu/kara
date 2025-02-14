<?php

namespace Database\Seeders;

use App\Models\StatusKelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        StatusKelas::create([
            'kode' => 'aktif',
            'nama' => 'Masih di kelas',
            'keterangan' => 'Siswa aktif mengikuti kelas'
        ]);

        StatusKelas::create([
            'kode' => 'pindah',
            'nama' => 'Pindah ke kelas lain',
            'keterangan' => 'Siswa pindah ke kelas lain atau sekolah lain'
        ]);

        StatusKelas::create([
            'kode' => 'lulus',
            'nama' => 'Lulus',
            'keterangan' => 'Siswa telah menyelesaikan jenjang pendidikan'
        ]);

        StatusKelas::create([
            'kode' => 'dropout',
            'nama' => 'Dropout',
            'keterangan' => 'Siswa keluar atau berhenti mengikuti pendidikan'
        ]);

        StatusKelas::create([
            'kode' => 'cuti',
            'nama' => 'Cuti',
            'keterangan' => 'Siswa mengambil cuti sementara'
        ]);

        StatusKelas::create([
            'kode' => 'tunda',
            'nama' => 'Kenaikan Kelas Tunda',
            'keterangan' => 'Siswa tertunda kenaikan kelas'
        ]);

        StatusKelas::create([
            'kode' => 'sakit',
            'nama' => 'Sakit',
            'keterangan' => 'Siswa sedang dalam pemulihan sakit dan tidak aktif di kelas'
        ]);

        StatusKelas::create([
            'kode' => 'penggantian',
            'nama' => 'Penggantian Kelas',
            'keterangan' => 'Siswa dipindahkan ke kelas lain untuk alasan tertentu'
        ]);

        StatusKelas::create([
            'kode' => 'rehabilitasi',
            'nama' => 'Rehabilitasi',
            'keterangan' => 'Siswa mengikuti program rehabilitasi'
        ]);

        StatusKelas::create([
            'kode' => 'nonaktif',
            'nama' => 'Nonaktif',
            'keterangan' => 'Siswa sudah tidak aktif dalam kelas, tapi belum keluar atau lulus'
        ]);

        StatusKelas::create([
            'kode' => 'meninggal',
            'nama' => 'Meninggal',
            'keterangan' => 'Siswa meninggal dunia'
        ]);

        StatusKelas::create([
            'kode' => 'suspensi',
            'nama' => 'Suspensi',
            'keterangan' => 'Siswa diberi sanksi berupa penangguhan sementara dari kelas'
        ]);
    }

}
