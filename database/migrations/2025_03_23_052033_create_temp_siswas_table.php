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
        Schema::create('temp_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upload_siswa_id')->constrained('upload_siswas')->onDelete('cascade');
            $table->string('nama');
            $table->string('nis')->unique()->nullable();
            $table->foreignId('rombel_id')->nullable()->constrained('rombels')->onDelete('cascade'); // Relasi ke tabel Rombel
            $table->foreignId('tingkat_id')->nullable()->constrained('tingkats')->onDelete('cascade'); // Relasi ke tabel Rombel
            $table->string('rombel_name', 20)->nullable();
            $table->string('romawi', 4)->nullable();
            $table->string('status', 25)->default('pending'); // pending, processing, completed, failed
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_siswas');
    }
};
