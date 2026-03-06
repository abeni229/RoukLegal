<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * We'll add two nullable columns to the users table:
     * - profession_libre: free-text profession when the dropdown doesn't fit
     *     this will allow actors to enter anything
     * - photo_professionnelle: path to the uploaded professional photo
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profession_libre')->nullable()->after('profession_id');
            $table->string('photo_professionnelle')->nullable()->after('profession_libre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profession_libre', 'photo_professionnelle']);
        });
    }
};