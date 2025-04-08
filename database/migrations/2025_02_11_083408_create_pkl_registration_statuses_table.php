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
        Schema::create('pkl_registration_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('pkl_registrations')->onDelete('cascade'); // Pendaftaran siswa
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade'); // siswa id
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade'); // jurusan siswa
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Role yang menyetujui
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // User yang approve
            $table->enum('status', ['pending', 'completed', 'rejected', 'resubmission', 'revisi'])->default('pending'); // Status approval
            $table->timestamp('status_updated_at')->nullable();
            $table->text('notes')->nullable(); // Catatan jika ada alasan penolakan
            $table->boolean('is_view')->default(false);
            $table->boolean('is_revisi')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkl_registration_statuses');
    }
};
