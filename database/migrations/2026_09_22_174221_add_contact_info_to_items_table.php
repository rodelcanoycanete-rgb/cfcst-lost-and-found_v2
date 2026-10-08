<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('facebook_link')->nullable()->after('images');
            $table->string('contact_number')->nullable()->after('facebook_link');
            $table->string('email')->nullable()->after('contact_number');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['facebook_link', 'contact_number', 'email']);
        });
    }
};