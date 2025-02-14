<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pkl_periodes', function (Blueprint $table) {
            $table->id();
            $table->string('name',100); // Tahun ajaran PKL (misal: 2024/2025)
            $table->string('tahun_ajaran',9); // Tahun ajaran PKL (misal: 2024/2025)
            $table->integer('kuota_siswa'); // Batas jumlah siswa yang bisa daftar
            $table->date('batas_registrasi'); // Deadline pendaftaran
            $table->text('syarat_pendaftaran')->nullable(); // Syarat pendaftaran untuk siswa
            $table->date('tanggal_mulai'); // Tanggal mulai PKL
            $table->date('tanggal_selesai'); // Tanggal selesai PKL
            $table->boolean('is_active')->default(false); // Apakah pendaftaran sedang aktif?
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkl_periodes');
    }
};
