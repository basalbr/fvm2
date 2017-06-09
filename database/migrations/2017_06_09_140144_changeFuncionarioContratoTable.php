<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFuncionarioContratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funcionario_contrato', function (Blueprint $table) {
            $table->string('sindicato')->nullable()->change();
            $table->integer('dsr')->change();
            $table->boolean('sindicalizado')->default(false)->change();
            $table->boolean('vale_transporte')->default(false);
            $table->float('valor_vale_transporte')->nullable()->change();
            $table->float('desconto_assistencia_medica')->nullable()->change();
            $table->integer('id_vinculo_empregaticio')->unsigned();
            $table->foreign('id_vinculo_empregaticio')->references('id')->on('vinculo_empregaticio')->onDelete('cascade');
            $table->integer('id_categoria_contrato_trabalho')->unsigned();
            $table->foreign('id_categoria_contrato_trabalho')->references('id')->on('categoria_contrato_trabalho')->onDelete('cascade');
            $table->integer('id_situacao_seguro_desemprego')->unsigned();
            $table->foreign('id_situacao_seguro_desemprego')->references('id')->on('situacao_seguro_desemprego')->onDelete('cascade');
            $table->boolean('banco_horas')->default(false);
            $table->boolean('desconta_vale_transporte')->default(false)->change();
            $table->boolean('contrato_experiencia')->default(false)->change();
            $table->boolean('professor')->default(false)->change();
            $table->boolean('experiencia')->default(false);
            $table->boolean('primeiro_emprego')->default(false)->change();
            $table->integer('qtde_dias_experiencia')->nullable()->change();
            $table->integer('qtde_dias_prorrogacao_experiencia')->nullable();
            $table->dropColumn(['situacao_seguro_desemprego','vinculo_empregaticio','data_final_prorrogacao_experiencia','data_inicio_prorrogacao_experiencia','data_final_experiencia','data_inicio_experiencia','possui_banco_de_horas','pagou_contribuicao','qtde_dias_vale_transporte', 'valor_assistencia_medica']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funcionario_contrato', function (Blueprint $table) {
            //
        });
    }
}
