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
        Schema::create('ijin_siswa_pkls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('dudi_id')->constrained('dudis')->onDelete('cascade');
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->text('alasan');
            $table->string('lampiran')->nullable(); // file bukti/pendukung

            // Verifikasi
            $table->enum('status_pembimbing_instansi', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('status_guru_pembimbing', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_pembimbing')->nullable();
            $table->text('catatan_guru')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ijin_siswa_pkls');
    }
};
