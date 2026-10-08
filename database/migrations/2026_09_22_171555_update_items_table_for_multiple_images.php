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
        Schema::table('items', function (Blueprint $table) {
            // Drop old single image column if it exists in the table
            if (Schema::hasColumn('items', 'image')) {
                $table->dropColumn('image');
            }
            
            // Add new JSON column to support multiple image angles (1 to 4 photos)
            if (!Schema::hasColumn('items', 'images')) {
                $table->json('images')->nullable()->after('date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Rollback changes if needed
            if (Schema::hasColumn('items', 'images')) {
                $table->dropColumn('images');
            }
            
            if (!Schema::hasColumn('items', 'image')) {
                $table->string('image')->nullable();
            }
        });
    }
};