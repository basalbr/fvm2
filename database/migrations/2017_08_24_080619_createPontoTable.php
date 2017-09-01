<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePontoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ponto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->foreign('id_empresa')->references('id')->on('empresa')->onDelete('cascade');
            $table->date('periodo');
            $table->string('status')->default('pendente');
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
        Schema::dropIfExists('ponto');
    }
}
