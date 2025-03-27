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
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->onDelete('cascade'); // jurusan siswa
            $table->foreignId('dudi_id')->nullable()->constrained('dudis')->onDelete('cascade'); // jurusan siswa
            $table->foreignId('pegawai_id')->nullable()->constrained('pegawais')->onDelete('cascade'); // jurusan siswa
            $table->enum('registration_type', ['mandiri', 'seleksi']); // Jenis pendaftaran
            $table->enum('status_register', ['pending', 'completed', 'rejected'])->default('pending'); // Status awal
            $table->enum('status_pelaksana', ['pending', 'completed', 'rejected','mutasi'])->default('pending'); // Status awal
            $table->timestamp('status_updated_at')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->string('tahun_pelajaran', 9);
            $table->foreignId('tingkat_id')->nullable()->constrained('tingkats')->onDelete('cascade'); // jurusan siswa
            $table->string('kelas',15)->nullable();
            $table->string('jurusan_name',75)->nullable();
            $table->string('guru_name',75)->nullable();
            $table->string('guru_nip',20)->nullable();
            $table->string('guru_hp',15)->nullable();
            $table->string('pembina_name',75)->nullable();
            $table->string('pembina_no',25)->nullable();
            $table->string('pembina_jabatan',25)->nullable();
            $table->string('pembina_hp',15)->nullable();
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
