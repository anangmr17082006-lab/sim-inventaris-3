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
        Schema::create('disposals', function (Blueprint $table) {
            $table->id();

            // Asset being disposed
            $table->foreignId('asset_detail_id')->constrained('asset_details')->onDelete('cascade');

            // Disposal information
            $table->string('disposal_type'); // Will store DisposalType enum value
            $table->string('status')->default('pending'); // Will store DisposalStatus enum value
            $table->text('reason'); // Required: min 20 chars
            $table->string('evidence_photo'); // Required: path to uploaded photo
            $table->decimal('book_value', 15, 2)->nullable(); // Asset value at disposal time

            // Approval workflow tracking
            $table->foreignId('requested_by')->constrained('users'); // Staff who requested
            $table->foreignId('reviewed_by')->nullable()->constrained('users'); // Admin who reviewed
            $table->timestamp('approved_at')->nullable(); // When approved/rejected

            // Additional notes (e.g., compensation info, admin remarks)
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes(); // For disposal record archival
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposals');
    }
};
