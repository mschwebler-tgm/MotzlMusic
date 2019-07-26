<?php

use App\Track;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTrackTypeToProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->enum('provider', ['spotify', 'local']);
        });
        $tracks = Track::all();
        foreach ($tracks as $track) {
            $track->provider = $track->type;
            $track->save();
        }
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->enum('type', ['spotify', 'local']);
        });
        $tracks = Track::all();
        foreach ($tracks as $track) {
            $track->type = $track->provider;
            $track->save();
        }
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn('provider');
        });
    }
}
