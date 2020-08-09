<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaixaSimplesNacionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faixa_simples_nacional', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tabela_simples_nacional')->unsigned();
            $table->foreign('id_tabela_simples_nacional')->references('id')->on('tabela_simples_nacional')->onDelete('cascade');
            $table->string('descricao');
            $table->decimal('de', 10, 2);
            $table->decimal('ate', 10, 2);
            $table->decimal('aliquota', 5, 2);
            $table->decimal('deducao', 10, 2);
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
        Schema::dropIfExists('faixa_simples_nacional');
    }
}
