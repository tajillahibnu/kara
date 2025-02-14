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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nip', 18)->unique()->nullable(); // Nomor Induk Pegawai (opsional untuk karyawan non-guru)
            $table->string('nik', 16)->unique()->nullable(); // Nomor Induk Kependudukan
            $table->string('name', 150);
            $table->enum('jk', ['P', 'L']);
            $table->string('telepon', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir');
            $table->string('email', 150)->unique();
            $table->enum('status_kepegawaian', ['PNS', 'Honorer'])->default('PNS');
            $table->enum('jabatan', ['Guru', 'Staff TU','Staff', 'Kepala Sekolah', 'Wakil Kepala'])->default('Guru');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
