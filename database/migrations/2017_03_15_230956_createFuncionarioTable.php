<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->foreign('id_empresa')->references('id')->on('empresa')->onDelete('cascade');
            $table->integer('id_uf_ctps')->unsigned();
            $table->foreign('id_uf_ctps')->references('id')->on('uf')->onDelete('cascade');
            $table->integer('id_uf')->unsigned();
            $table->foreign('id_uf')->references('id')->on('uf')->onDelete('cascade');
            $table->string('nome_completo');
            $table->string('nome_mae');
            $table->string('nome_pai');
            $table->string('nome_conjuge')->nullable();
            $table->string('nacionalidade');
            $table->string('naturalidade');
            $table->string('grau_instrucao');
            $table->string('grupo_sanguineo');
            $table->string('raca_cor');
            $table->char('sexo', 1);
            $table->date('data_nascimento');
            $table->string('cpf', 14);
            $table->string('rg', 14);
            $table->string('orgao_expeditor_rg');
            $table->date('data_emissao_rg');
            $table->string('titulo_eleitoral');
            $table->string('zona_secao_eleitoral');
            $table->string('carteira_reservista')->nullable();
            $table->string('categoria_carteira_reservista')->nullable();
            $table->string('cnh')->nullable();
            $table->string('categoria_cnh')->nullable();
            $table->string('vencimento_cnh')->nullable();
            $table->string('email');
            $table->string('telefone', 15);
            $table->string('data_chegada_estrangeiro')->nullable();
            $table->string('condicao_trabalhador_estrangeiro')->nullable();
            $table->string('numero_processo_mte')->nullable();
            $table->string('validade_carteira_trabalho')->nullable();
            $table->boolean('casado_estrangeiro')->nullable();
            $table->boolean('filho_estrangeiro')->nullable();
            $table->string('numero_rne')->nullable();
            $table->string('orgao_emissor_rne')->nullable();
            $table->string('data_validade_rne')->nullable();
            $table->string('cep');
            $table->string('bairro');
            $table->string('endereco');
            $table->integer('numero')->nullable();
            $table->string('cidade');
            $table->string('complemento')->nullable();
            $table->boolean('residente_exterior')->nullable();
            $table->boolean('residencia_propria')->nullable();
            $table->boolean('imovel_recurso_fgts')->nullable();
            $table->string('pis');
            $table->date('data_cadastro_pis');
            $table->string('ctps');
            $table->date('data_expedicao_ctps');
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
        Schema::dropIfExists('funcionario');
    }
}
