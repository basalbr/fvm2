<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeIdTipoAlteracaoInAlteracaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alteracao', function (Blueprint $table) {
            $table->dropForeign('alteracao_id_tipo_alteracao_foreign');
            $table->integer('id_tipo_alteracao')->nullable()->unsigned()->change();
            $table->foreign('id_tipo_alteracao')->references('id')->on('tipo_alteracao')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alteracao', function (Blueprint $table) {
            //
        });
    }
}
