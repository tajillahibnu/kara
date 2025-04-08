<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_pkl_siswa");
        DB::statement("
            CREATE VIEW view_pkl_siswa AS
            SELECT 
                pkl_registrations.id, 
                pkl_registrations.periode_id, 
                pkl_registrations.siswa_id, 
                pkl_registrations.jurusan_id, 
                pkl_registrations.dudi_id, 
                pkl_registrations.pegawai_id, 
                pkl_registrations.registration_type, 
                pkl_registrations.status_register, 
                pkl_registrations.status_pelaksana, 
                pkl_registrations.status_updated_at, 
                pkl_registrations.tanggal_mulai, 
                pkl_registrations.tanggal_berakhir, 
                pkl_registrations.tahun_pelajaran, 
                pkl_registrations.tingkat_id, 
                pkl_registrations.kelas, 
                pkl_registrations.jurusan_name, 
                pkl_registrations.guru_name, 
                pkl_registrations.guru_nip, 
                pkl_registrations.guru_hp, 
                pkl_registrations.pembina_name, 
                pkl_registrations.pembina_no, 
                pkl_registrations.pembina_jabatan, 
                pkl_registrations.pembina_hp, 
                siswas.nis, 
                siswas.`name`, 
                siswas.tempat_lahir, 
                siswas.tanggal_lahir, 
                siswas.jk
            FROM pkl_registrations
            INNER JOIN siswas ON pkl_registrations.siswa_id = siswas.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_pkl_siswa");
    }
};
