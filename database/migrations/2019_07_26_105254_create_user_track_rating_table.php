<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTrackRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_track_ratings', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('track_id');
            $table->float('rating');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('track_id')->references('id')->on('tracks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_track_ratings');
    }
}
