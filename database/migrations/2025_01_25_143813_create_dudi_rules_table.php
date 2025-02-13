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
        Schema::create('dudi_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dudi_id')->constrained('dudis')->onDelete('cascade'); // Relasi ke DUDI
            $table->string('rule_type'); // Jenis aturan (misalnya: 'max_siswa_motor', 'max_siswa_perempuan')
            $table->integer('value'); // Nilai aturan (contoh: 5, 3, dll.)
            $table->timestamps(); // Timestamps untuk pencatatan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dudi_rules');
    }
};
