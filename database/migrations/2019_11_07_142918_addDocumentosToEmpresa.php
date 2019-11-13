<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocumentosToEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresa', function (Blueprint $table) {
            $table->boolean('need_ato_constitutivo')->default(false);
            $table->boolean('need_alteracao')->default(false);
            $table->boolean('need_gfip')->default(false);
            $table->boolean('need_ficha_funcionario')->default(false);
            $table->boolean('need_balancete')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresa', function (Blueprint $table) {
            $table->dropColumn(['need_ato_constitutivo', 'need_alteracao', 'need_gfip', 'need_ficha_funcionario', 'need_balancete']);
        });
    }
}
