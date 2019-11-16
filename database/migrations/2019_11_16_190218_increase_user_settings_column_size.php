<?php

use App\Components\UserSettings\UserSettings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseUserSettingsColumnSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->longText('settings')
                ->default(UserSettings::defaultSettingsJSON())
                ->change();
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
            $table->string('settings', 13000)
                ->default(UserSettings::defaultSettingsJSON())
                ->change();
        });
    }
}
