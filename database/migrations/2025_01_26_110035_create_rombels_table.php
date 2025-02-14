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
        Schema::create('rombels', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('kode', 20)->unique(); // Unique code for the rombel
            $table->string('label', 100)->nullable(); // Name of the rombel
            $table->string('name', 100); // Name of the rombel
            $table->unsignedBigInteger('walikelas_id')->nullable(); // Relation to the teacher who manages the rombel
            $table->unsignedBigInteger('jurusan_id')->nullable(); // Relation to a specific department or major
            $table->string('jurusan_name', 100)->nullable();
            // $table->integer('tingkat'); // Grade level, e.g., 10, 11, 12
            $table->foreignId('tingkat_id')->constrained()->onDelete('cascade'); // Relasi ke Kurikulum
            $table->string('romawi', 8)->nullable();
            $table->integer('kapasitas')->default(0); // Capacity of the rombel
            $table->string('tahun_ajaran', 9); // Academic year, e.g., 2024/2025
            $table->boolean('is_active')->default(false);
            $table->enum('tipe', ['KBM', 'EKTRAKURIKULER', 'KBM_KELOMPOK', 'GABUNGAN'])->default('KBM');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            // $table->foreign('walikelas_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombels');
    }
};
