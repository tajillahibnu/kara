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
        Schema::create('status_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();  // Kode status kelas
            $table->string('nama');            // Nama status kelas
            $table->text('keterangan')->nullable(); // Keterangan opsional
            $table->timestamps();  // Tanggal dibuat dan diperbarui
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_kelas');
    }
};
