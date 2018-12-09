<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('popularity')->nullable();
            $table->unsignedInteger('album_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->string('spotify_id')->nullable();
            $table->string('spotify_href')->nullable();
            $table->string('spotify_uri')->nullable();
            $table->timestamps();

            $table->foreign('album_id')->references('id')->on('albums');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
