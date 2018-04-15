<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmoSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amo_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('settingable');

            $table->integer('status')
                ->nullable()
                ->comment('Status');

            $table->tinyInteger('minimum_duration')
                ->nullable()
                ->comment('Minimum duration');

            $table->tinyInteger('recording')
                ->nullable()
                ->comment('Recording mask');

            $table->string('roistat')
                ->nullable()
                ->comment('Roistat');

            $table->integer('field')
                ->nullable()
                ->comment('Custom field');
            $table->integer('value')
                ->nullable()
                ->comment('Value for custom field');

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
        Schema::dropIfExists('amo_settings');
    }
}
