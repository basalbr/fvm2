<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpostoFaixaSimplesNacionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imposto_faixa_simples_nacional', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_faixa_simples_nacional')->unsigned();
            $table->foreign('id_faixa_simples_nacional')->references('id')->on('faixa_simples_nacional')->onDelete('cascade');
            $table->string('descricao');
            $table->decimal('valor', 10, 2);
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
        Schema::dropIfExists('imposto_faixa_simples_nacional');
    }
}
