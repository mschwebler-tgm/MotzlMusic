<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpotifyAudioFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spotify_audio_features', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('track_id');
            $table->unsignedDecimal('energy');
            $table->unsignedDecimal('valence');
            $table->unsignedDecimal('danceability');
            $table->unsignedDecimal('speechiness');
            $table->unsignedDecimal('acousticness');
            $table->unsignedDecimal('instrumentalness');
            $table->unsignedDecimal('liveness');
            $table->decimal('loudness');
            $table->tinyInteger('key');
            $table->tinyInteger('mode');
            $table->unsignedDecimal('tempo');
            $table->string('spotify_id');

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
        Schema::dropIfExists('spotify_audio_features');
    }
}
