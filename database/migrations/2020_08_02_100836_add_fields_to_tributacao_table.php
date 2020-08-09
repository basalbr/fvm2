<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToTributacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tributacao', function (Blueprint $table) {
            $table->integer('id_tabela_simples_nacional')->unsigned()->nullable();
            $table->foreign('id_tabela_simples_nacional')->references('id')->on('tabela_simples_nacional')->onDelete('cascade');
            $table->string('mercado')->default('interno');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tributacao', function (Blueprint $table) {
            //
        });
    }
}
