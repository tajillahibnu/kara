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
        Schema::create('pkl_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('pkl_periodes')->onDelete('cascade'); // Periode PKL
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Jabatan yang berhak approve
            $table->boolean('is_required')->default(true); // Apakah approval wajib?
            $table->boolean('can_override')->default(false);
            $table->enum('approval_type', ['mandiri', 'seleksi']); // Jenis pendaftaran
            $table->integer('approval_order'); // Urutan approval (1, 2, 3, dst.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkl_approvals');
    }
};
