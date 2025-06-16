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
    Schema::table('umkms', function (Blueprint $table) {
        $table->string('facebook_url')->nullable();
        $table->string('instagram_url')->nullable();
        $table->string('tiktok_url')->nullable();
    });
}

public function down(): void
{
    Schema::table('umkms', function (Blueprint $table) {
        $table->dropColumn(['facebook_url', 'instagram_url', 'tiktok_url']);
    });
}
};
