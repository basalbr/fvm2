<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegimeCasamentoToAberturaEmpresaSocio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abertura_empresa_socio', function (Blueprint $table) {
            $table->dropColumn('regime_casamento');
            $table->integer('id_regime_casamento')->unsigned()->nullable()->default(null);
            $table->foreign('id_regime_casamento')->references('id')->on('regime_casamento')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abertura_empresa_socio', function (Blueprint $table) {
            //
        });
    }
}
