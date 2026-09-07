<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('myleads', function (Blueprint $table) {
            $table->unsignedBigInteger('booked_by')->nullable()->after('user_id');
            $table->timestamp('booked_at')->nullable()->after('booked_by');
            $table->foreign('booked_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::table('myleads', function (Blueprint $table) {
            $table->dropForeign(['booked_by']);
            $table->dropColumn(['booked_by', 'booked_at']);
        });
    }
};
?>
