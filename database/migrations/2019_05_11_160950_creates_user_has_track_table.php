<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatesUserHasTrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_track', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('track_id');
            $table->enum('type', ['owner', 'subscribed']);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('track_id')->references('id')->on('tracks');
        });

        Artisan::call('db:seed', ['--class' => MigrateTrackUserIdToUserHasTrackTable::class]);

        Schema::table('tracks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_track');
        Schema::table('tracks', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
