<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beelines', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('company_id')
                ->unsigned();

            $table->uuid('token');

            $table->uuid('subscribe_id')
                ->nullable();
            $table->string('subscribe_extension')
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
        Schema::dropIfExists('beelines');
    }
}
