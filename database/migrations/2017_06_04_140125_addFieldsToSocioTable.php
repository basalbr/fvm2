<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToSocioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('socio', function (Blueprint $table) {
            $table->string('nome_mae');
            $table->string('nome_pai');
            $table->string('complemento')->nullable();
            $table->string('email');
            $table->string('telefone');
            $table->string('nacionalidade');
            $table->string('estado_civil');
            $table->string('pis')->nullable()->change();
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
        Schema::table('socio', function (Blueprint $table) {
            $table->dropForeign('socio_id_regime_casamento_foreign');
            $table->string('pis')->change();
            $table->dropColumn(['nome_mae', 'telefone', 'nome_pai', 'complemento', 'email', 'nacionalidade', 'estado_civil', 'id_regime_casamento']);
        });
    }
}
