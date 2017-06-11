<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFuncionarioDeficienciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funcionario_deficiencia', function (Blueprint $table) {
            $table->dropColumn(['deficiencia']);
            $table->integer('id_tipo_deficiencia')->unsigned();
            $table->foreign('id_tipo_deficiencia')->references('id')->on('tipo_deficiencia')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funcionario_deficiencia', function (Blueprint $table) {
            //
        });
    }
}
