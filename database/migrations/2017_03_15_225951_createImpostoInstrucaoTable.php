<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpostoInstrucaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imposto_instrucao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_imposto')->unsigned();
            $table->text('descricao');
            $table->integer('ordem')->unsigned();
            $table->foreign('id_imposto')->references('id')->on('imposto')->onDelete('cascade');
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
        Schema::dropIfExists('imposto_instrucao');
    }
}
