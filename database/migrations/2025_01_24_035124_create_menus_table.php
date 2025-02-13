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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title',100)->nullable(); // Nama menu
            $table->string('name',150); // Nama menu
            $table->string('slug',50)->unique()->nullable(); // Lokasi halaman yang akan ditampilkan
            $table->string('url',50)->nullable(); // Lokasi halaman yang akan ditampilkan
            $table->foreignId('parent_id')->nullable()->constrained('menus')->onDelete('cascade'); // Relasi ke menu utama (jika sub-menu)
            $table->integer('level')->nullable(); // Menandakan apakah ini menu utama
            $table->string('type',50)->default('admin'); // Jenis menu: 'portal' atau 'admin'
            $table->integer('menu_order')->default(0); // Urutan tampilan menu
            $table->string('method')->default('index'); // Jenis menu: 'portal' atau 'admin'
            $table->string('view_path',150)->nullable(); // Jenis menu: 'portal' atau 'admin'
            $table->string('view_file',100)->nullable(); // Jenis menu: 'portal' atau 'admin'
            $table->json('middlewares')->nullable(); // Middleware sebagai JSON
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
