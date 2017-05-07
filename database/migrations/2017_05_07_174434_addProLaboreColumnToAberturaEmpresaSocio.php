<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProLaboreColumnToAberturaEmpresaSocio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abertura_empresa_socio', function (Blueprint $table) {
            $table->float('pro_labore')->nullable();
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
