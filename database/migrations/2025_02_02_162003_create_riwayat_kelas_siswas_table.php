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
        Schema::create('riwayat_kelas_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');  // Relasi ke tabel siswa
            $table->foreignId('status_kelas_id')->constrained('status_kelas')->onDelete('cascade'); // Relasi ke status kelas
            $table->foreignId('rombel_id')->constrained('rombels')->onDelete('cascade'); // Relasi ke kelas
            $table->string('tahun_ajaran',9);  // Tahun ajaran saat status kelas berlaku
            $table->date('tanggal_masuk')->nullable();  // Tanggal siswa masuk kelas
            $table->date('tanggal_keluar')->nullable(); // Tanggal siswa keluar kelas
            $table->timestamps();  // Tanggal dan waktu perubahan status kelas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_kelas_siswas');
    }
};
