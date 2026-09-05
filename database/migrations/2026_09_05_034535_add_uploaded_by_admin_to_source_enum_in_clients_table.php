<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE clients MODIFY COLUMN source ENUM('website', 'referral', 'cold_outreach', 'social_media', 'event', 'other', 'uploaded_by_admin') DEFAULT 'other'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE clients MODIFY COLUMN source ENUM('website', 'referral', 'cold_outreach', 'social_media', 'event', 'other') DEFAULT 'other'");
    }
};
