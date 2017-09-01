<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlteracaoContratualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alteracao_contratual', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_funcionario')->unsigned();
            $table->foreign('id_funcionario')->references('id')->on('funcionario')->onDelete('cascade');
            $table->integer('id_tipo_alteracao_contratual')->unsigned();
            $table->foreign('id_tipo_alteracao_contratual')->references('id')->on('tipo_alteracao_contratual')->onDelete('cascade');
            $table->float('salario')->nullable();
            $table->string('dsr')->nullable();
            $table->text('motivo')->nullable();
            $table->date('data_alteracao')->nullable();
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
        Schema::dropIfExists('alteracao_contratual');
    }
}
