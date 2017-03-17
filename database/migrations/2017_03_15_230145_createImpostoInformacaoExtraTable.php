<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpostoInformacaoExtraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imposto_informacao_extra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_imposto')->unsigned();
            $table->foreign('id_imposto')->references('id')->on('imposto')->onDelete('cascade');
            $table->string('tipo');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->integer('tamanho_maximo')->nullable();
            $table->string('tabela')->nullable();
            $table->string('campo')->nullable();
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
        Schema::dropIfExists('imposto_informacao_extra');
    }
}
