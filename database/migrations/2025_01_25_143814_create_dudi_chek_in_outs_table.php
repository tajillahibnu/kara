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
        Schema::create('dudi_chek_in_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dudi_id')->constrained('dudis')->onDelete('cascade');
            $table->string('shift'); // Pagi, Siang, Malam
            $table->unsignedTinyInteger('day_number'); // 1 = Senin, 2 = Selasa, dst.
            $table->string('day_slug'); // monday, tuesday, wednesday, etc.
            $table->time('clock_in');
            $table->time('clock_out');
            $table->time('ramadhan_clock_in')->nullable();
            $table->time('ramadhan_clock_out')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dudi_chek_in_outs');
    }
};
