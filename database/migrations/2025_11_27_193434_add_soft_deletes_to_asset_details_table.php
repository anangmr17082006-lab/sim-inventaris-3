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
        Schema::table('asset_details', function (Blueprint $table) {
            $table->softDeletes(); // Add deleted_at column for soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_details', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Remove deleted_at column
        });
    }
};
