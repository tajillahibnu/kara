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
        DB::statement("DROP VIEW IF EXISTS view_rombels");
        DB::statement("
            CREATE VIEW view_rombels AS
            SELECT
                rombels.id,
                rombels.kode,
                rombels.label,
                rombels.`name`,
                rombels.jurusan_name,
                rombels.tingkat_id,
                rombels.romawi,
                rombels.kapasitas,
                rombels.tahun_ajaran,
                rombels.is_active,
                rombels.tipe,
                rombels.walikelas_id,
                rombels.jurusan_id,
                jurusans.kode AS kode_jurusan,
                jurusans.`name` AS nama_jurusan,
                pegawais.nip,
                pegawais.nik,
                pegawais.`name` AS walikelas_name,
                pegawais.jk,
                pegawais.telepon,
                pegawais.alamat,
                pegawais.email,
                pegawais.jabatan
            FROM
                rombels
                INNER JOIN jurusans ON rombels.jurusan_id = jurusans.id
                LEFT JOIN pegawais ON rombels.walikelas_id = pegawais.id
            WHERE rombels.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_rombels");
    }
};
