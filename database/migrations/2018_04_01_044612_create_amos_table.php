<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
