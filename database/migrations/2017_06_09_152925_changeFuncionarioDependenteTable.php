<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFuncionarioDependenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funcionario_dependente', function (Blueprint $table) {
            $table->integer('id_tipo_dependencia')->unsigned();
            $table->foreign('id_tipo_dependencia')->references('id')->on('tipo_dependencia')->onDelete('cascade');
            $table->string('local_nascimento')->change();
            $table->string('orgao_expedidor_rg')->nullable();
            $table->string('numero_livro')->nullable();
            $table->dropColumn(['data_entrega_documento','orgao_rg','tipo_dependencia']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funcionario_dependente', function (Blueprint $table) {
            //
        });
    }
}
