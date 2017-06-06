<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsMensalidade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mensalidade', function (Blueprint $table) {
            $table->integer('qtde_documento_fiscal');
            $table->integer('qtde_documento_contabil');
            $table->integer('qtde_funcionario');
            $table->integer('qtde_pro_labore');
            $table->dropColumn(['qtde_documentos_fiscais', 'qtde_documentos_contabeis', 'qtde_funcionarios', 'qtde_pro_labores']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mensalidade', function (Blueprint $table) {
            //
        });
    }
}
