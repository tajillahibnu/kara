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
        Schema::create('attendance_pkls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('dudi_id')->constrained('dudis')->onDelete('cascade');
            $table->foreignId('periode_id')->constrained('pkl_periodes')->onDelete('cascade');
            $table->date('tanggal');
            $table->timestamp('clock_in')->nullable();
            $table->timestamp('clock_out')->nullable();
            $table->timestamp('clock_in_real')->nullable();
            $table->timestamp('clock_out_real')->nullable();
            $table->string('status')->default('pending');
            $table->integer('durasi')->default('0');
            $table->integer('durasi_real')->default('0');
            $table->string('tahun_pelajaran', 9)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_pkls');
    }
};
