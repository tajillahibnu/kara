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
        Schema::create('pkl_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('pkl_periodes')->onDelete('cascade'); // Periode PKL
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade'); // Siswa yang mendaftar
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade'); // jurusan siswa
            $table->enum('registration_type', ['mandiri', 'seleksi']); // Jenis pendaftaran
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status awal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkl_registrations');
    }
};
