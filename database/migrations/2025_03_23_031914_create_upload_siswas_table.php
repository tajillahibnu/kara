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
        Schema::create('upload_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('filename',100); // Nama file di MinIO
            $table->string('original_name'); // Nama asli file
            $table->string('file_type'); // Tipe file (csv, xlsx)
            $table->bigInteger('file_size'); // Ukuran file dalam bytes
            $table->integer('row_count')->nullable(); // Jumlah baris dalam file
            $table->string('url')->nullable(); // URL download file
            $table->string('status')->default('pending'); // pending, processing, completed, failed
            $table->text('errors')->nullable(); // Catatan error jika ada
            $table->string('path'); // Lokasi simpan
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade')->nullable();
            $table->timestamp('processing_started_at')->nullable();
            $table->timestamp('processing_completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_siswas');
    }
};
