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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['lost', 'found']); // Lost or Found report type
            $table->string('category');
            $table->string('location');
            $table->date('date');
            
            // Poster / Founder Identity Fields
            $table->string('full_name');
            $table->string('student_id');
            $table->string('department');
            
            // Contact Fields
            $table->string('facebook_link')->nullable();
            $table->string('contact_number');
            $table->string('email');

            // Media & Status Fields
            $table->text('images')->nullable(); // Stores JSON array of image paths
            $table->string('status')->default('pending'); // Admin approval status: pending, approved, claimed
            
            // Report / Moderation Fields
            $table->boolean('is_reported')->default(false);
            $table->integer('report_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};