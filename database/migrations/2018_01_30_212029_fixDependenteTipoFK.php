<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixDependenteTipoFK extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ir_dependente', function (Blueprint $table) {
            $table->dropForeign('ir_dependente_id_ir_tipo_dependente_foreign');
            $table->foreign('id_ir_tipo_dependente')->references('id')->on('tipo_dependencia')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ir_dependente', function (Blueprint $table) {
            //
        });
    }
}
