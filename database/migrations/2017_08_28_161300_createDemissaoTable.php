<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemissaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demissao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_funcionario')->unsigned();
            $table->foreign('id_funcionario')->references('id')->on('funcionario')->onDelete('cascade');
            $table->integer('id_tipo_demissao')->unsigned();
            $table->integer('id_tipo_aviso_previo')->unsigned();
            $table->text('observacoes')->nullable();
            $table->date('data_demissao');
            $table->string('status')->default('pendente');
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
        Schema::dropIfExists('demissao');
    }
}
