<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mutations', function (Blueprint $table) {
            $table->id();

            // Relasi ke Aset yang dimutasi
            $table->foreignId('asset_id')->constrained('asset_details')->onDelete('cascade');

            // Ruangan Asal & Tujuan
            $table->foreignId('from_room_id')->constrained('rooms');
            $table->foreignId('to_room_id')->constrained('rooms');

            // Tanggal Mutasi
            $table->date('mutation_date');

            // Alasan & Kondisi Aset
            $table->text('reason');
            $table->enum('asset_condition', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->text('notes')->nullable();

            // Status Workflow: pending -> approved -> completed (atau rejected)
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');

            // User Tracking
            $table->foreignId('requested_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            // Index untuk performa query
            $table->index(['status', 'mutation_date']);
            $table->index('asset_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutations');
    }
};
