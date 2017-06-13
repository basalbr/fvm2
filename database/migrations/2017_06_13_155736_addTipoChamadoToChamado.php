<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoChamadoToChamado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chamado', function (Blueprint $table) {
            $table->integer('id_tipo_chamado')->unsigned();
            $table->foreign('id_tipo_chamado')->references('id')->on('tipo_chamado')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chamado', function (Blueprint $table) {
            //
        });
    }
}
