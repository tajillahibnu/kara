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
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); // Kode Jurusan SMK
            $table->string('name', 100); // Nama Jurusan SMK
            $table->string('bidang_keahlian', 100); // Bidang Keahlian
            $table->string('program_keahlian', 100); // Program Keahlian
            $table->text('deskripsi')->nullable(); // Deskripsi Jurusan
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
        Schema::dropIfExists('jurusans');
    }
};
