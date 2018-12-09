<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('popularity')->nullable();
            $table->string('spotify_id')->nullable();
            $table->string('spotify_href')->nullable();
            $table->string('spotify_uri')->nullable();
            $table->string('spotify_image_small')->nullable();
            $table->string('spotify_image_medium')->nullable();
            $table->string('spotify_image_large')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artists');
    }
}
