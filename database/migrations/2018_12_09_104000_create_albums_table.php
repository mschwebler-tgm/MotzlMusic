<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('popularity')->nullable();
            $table->string('label')->nullable();
            $table->date('release_date')->nullable();
            $table->unsignedInteger('total_tracks')->nullable();
            $table->string('spotify_id')->nullable();
            $table->string('spotify_href')->nullable();
            $table->string('spotify_uri')->nullable();
            $table->string('spotify_image_small', 1024)->nullable();
            $table->string('spotify_image_medium', 1024)->nullable();
            $table->string('spotify_image_large', 1024)->nullable();
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
        Schema::dropIfExists('albums');
    }
}
