<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveIdSituacaoSeguroDesempregoFromContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funcionario_contrato', function (Blueprint $table) {
            $table->dropForeign('funcionario_contrato_id_situacao_seguro_desemprego_foreign');
            $table->dropColumn(['id_situacao_seguro_desemprego']);

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
        });
    }
}
