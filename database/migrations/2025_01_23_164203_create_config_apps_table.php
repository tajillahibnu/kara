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
        Schema::create('config_apps', function (Blueprint $table) {
            $table->id();
            $table->string('config_kode', 50)->unique();
            $table->string('config_name', 100)->nullable();
            $table->string('config_title', 150)->nullable();
            $table->string('config_info', 50)->nullable();
            $table->string('config_tipe', 15)->nullable();
            $table->text('config_value')->nullable();
            $table->string('config_input', 20)->nullable();
            $table->string('config_description', 200)->nullable();
            $table->boolean('is_sensitive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_apps');
    }
};
