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
        Schema::create('pkl_priode_indukas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('priode_id')->constrained('pkl_periodes')->onDelete('cascade');
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');
            $table->foreignId('dudi_id')->constrained('dudis')->onDelete('cascade');
            $table->string('lokasi', 120)->nullable();
            $table->integer('kuota')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkl_priode_indukas');
    }
};
