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
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Role yang menyetujui
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // User yang approve
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status approval
            $table->text('notes')->nullable(); // Catatan jika ada alasan penolakan
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
