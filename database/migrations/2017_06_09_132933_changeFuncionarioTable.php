<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funcionario', function (Blueprint $table) {
            $table->dropColumn(['data_emissao_rg','orgao_expeditor_rg', 'data_expedicao_ctps','nome_conjuge', 'grau_instrucao', 'grupo_sanguineo', 'raca_cor', 'sexo', 'condicao_trabalhador_estrangeiro']);
            $table->integer('id_grau_instrucao')->unsigned();
            $table->foreign('id_grau_instrucao')->references('id')->on('grau_instrucao')->onDelete('cascade');
            $table->integer('id_grupo_sanguineo')->unsigned()->nullable();
            $table->foreign('id_grupo_sanguineo')->references('id')->on('grupo_sanguineo')->onDelete('cascade');
            $table->integer('id_raca')->unsigned()->nullable();
            $table->foreign('id_raca')->references('id')->on('raca')->onDelete('cascade');
            $table->integer('id_sexo')->unsigned();
            $table->foreign('id_sexo')->references('id')->on('sexo')->onDelete('cascade');
            $table->integer('id_condicao_estrangeiro')->unsigned()->nullable();
            $table->foreign('id_condicao_estrangeiro')->references('id')->on('condicao_estrangeiro')->onDelete('cascade');
            $table->boolean('novo_funcionario')->default(true);
            $table->string('telefone', 16)->change();
            $table->string('email')->nullable()->change();
            $table->boolean('estrangeiro')->default(false);
            $table->date('data_chegada_estrangeiro')->nullable()->change();
            $table->date('data_expedicao_rne')->nullable();
            $table->date('orgao_emissor_rne')->nullable()->change();
            $table->date('data_validade_rne')->nullable()->change();
            $table->boolean('residente_exterior')->default(false)->change();
            $table->boolean('residencia_propria')->default(false)->change();
            $table->boolean('imovel_recurso_fgts')->default(false)->change();
            $table->date('data_cadastro_pis')->nullable()->change();
            $table->date('data_emissao_ctps');
            $table->string('titulo_eleitoral')->nullable()->change();
            $table->string('zona_secao_eleitoral')->nullable()->change();
            $table->date('vencimento_cnh')->nullable()->change();
            $table->date('validade_carteira_trabalho')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funcionario', function (Blueprint $table) {
            //
        });
    }
}
