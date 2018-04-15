<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmoManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amo_managers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('amo_id')
                ->unsigned();

            $table->timestamps();

            $table->foreign('amo_id')
                ->references('id')
                ->on('amos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amo_managers');
    }
}
