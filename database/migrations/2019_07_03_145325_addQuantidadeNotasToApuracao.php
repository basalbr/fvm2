<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuantidadeNotasToApuracao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apuracao', function (Blueprint $table) {
            $table->integer('qtde_notas_servico')->nullable();
            $table->integer('qtde_notas_entrada')->nullable();
            $table->integer('qtde_notas_saida')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apuracao', function (Blueprint $table) {
            $table->dropColumn(['qtde_notas_servico', 'qtde_notas_entrada', 'qtde_notas_saida']);
        });
    }
}
