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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nis', 20)->unique()->nullable(); // Nomor Induk Siswa
            $table->string('name', 100);
            $table->string('tempat_lahir', 150)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jk', ['P', 'L']);
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');
            $table->foreignId('rombel_id')->nullable()->constrained('rombels')->onDelete('cascade'); // Relasi ke tabel Rombel
            $table->foreignId('tingkat_id')->constrained('tingkats')->onDelete('cascade'); // Relasi ke tabel Rombel
            $table->string('rombel_name', 20)->nullable();
            $table->string('romawi', 4)->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->boolean('is_pkl')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_lulus')->default(false);
            $table->string('tahun_masuk', 9)->nullable();
            $table->string('tahun_lulus', 9)->nullable();
            $table->string('email', 150)->unique();
            $table->string('no_wa', 16)->unique()->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('kode_kk', 16)->nullable(); // Nomor Induk Siswa
            $table->string('kode_nik', 16)->unique()->nullable(); // Nomor Induk Siswa
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
