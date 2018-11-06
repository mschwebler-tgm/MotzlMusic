<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdaptUsersTableToSpotify extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('spotify_id', 255)->unique()->nullable();
            $table->string('spotify_access_token', 512)->nullable();
            $table->string('spotify_refresh_token', 512)->nullable();
            $table->date('birthdate')->nullable();

            DB::statement('ALTER TABLE users MODIFY `password` VARCHAR(255) NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['spotify_id', 'spotify_access_token', 'spotify_refresh_token', 'birthdate']);

            DB::statement('ALTER TABLE users MODIFY `password` VARCHAR(255) NOT NULL');
        });
    }
}
