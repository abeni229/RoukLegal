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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_subscribed')->default(false);
            $table->timestamp('subscription_start')->nullable();
            $table->timestamp('subscription_end')->nullable();
            $table->timestamp('trial_end')->nullable();
            $table->integer('articles_viewed_today')->default(0);
            $table->json('viewed_authors')->nullable(); // Track authors whose articles were viewed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_subscribed', 'subscription_start', 'subscription_end', 'trial_end', 'articles_viewed_today', 'viewed_authors']);
        });
    }
};
