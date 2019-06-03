<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlteracaoTipoAlteracaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alteracao_tipo_alteracao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_alteracao')->unsigned();
            $table->foreign('id_alteracao')->references('id')->on('alteracao')->onDelete('cascade');
            $table->integer('id_tipo_alteracao')->unsigned();
            $table->foreign('id_tipo_alteracao')->references('id')->on('tipo_alteracao')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alteracao_tipo_alteracao');
    }
}
