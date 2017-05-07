<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentToAberturaEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abertura_empresa', function (Blueprint $table) {
            $table->integer('qtde_funcionario');
            $table->integer('qtde_documento_fiscal');
            $table->integer('qtde_documento_contabil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abertura_empresa', function (Blueprint $table) {
            //
        });
    }
}
