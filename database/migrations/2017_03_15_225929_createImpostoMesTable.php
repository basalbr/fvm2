<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpostoMesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imposto_mes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_imposto')->unsigned();
            $table->foreign('id_imposto')->references('id')->on('imposto')->onDelete('cascade');
            $table->integer('mes')->unsigned();
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
        Schema::dropIfExists('imposto_mes');
    }
}
