<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnotacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anotacao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('cascade');
            $table->string('referencia');
            $table->integer('id_referencia')->unsigned();
            $table->text('mensagem');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anotacao');
    }
}
