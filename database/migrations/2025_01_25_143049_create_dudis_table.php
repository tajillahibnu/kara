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
        Schema::create('dudis', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama DUDI
            $table->string('address'); // Alamat
            $table->string('phone')->nullable(); // Nomor Telepon Kantor
            $table->string('email')->unique()->nullable(); // Email DUDI
            $table->string('website')->nullable(); // Situs web DUDI

            // Koordinat Lokasi
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // PIC (Penanggung Jawab di DUDI)
            $table->string('pic_name')->nullable(); // Nama PIC
            $table->string('pic_phone')->nullable(); // Kontak PIC

            // Informasi Tambahan
            $table->integer('quota')->default(0); // Kuota siswa PKL
            $table->string('sector')->nullable(); // Sektor industri
            $table->string('partnership_status')->default('Belum Ada MoU'); // Status kerja sama
            $table->text('description')->nullable(); // Deskripsi DUDI
            $table->text('requirements')->nullable(); // Persyaratan siswa PKL
            
            $table->boolean('is_active')->default(false); // Status aktif/tidak
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dudis');
    }
};
