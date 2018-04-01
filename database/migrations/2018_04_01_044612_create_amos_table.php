<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('company_id')
                ->unsigned();

            $table->boolean('active')
                ->default(false);

            $table->string('domain');
            $table->string('login');
            $table->string('hash');

            $table->integer('status')
                ->nullable()
                ->comment('Status');

            $table->tinyInteger('minimum_duration')
                ->default(0)
                ->comment('Minimum duration');

            $table->tinyInteger('recording')
                ->default(3)
                ->comment('Recording mask');

            $table->string('roistat')
                ->nullable()
                ->comment('Roistat');

            $table->integer('field')
                ->nullable();
            $table->integer('value')
                ->nullable();

            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amos');
    }
}
