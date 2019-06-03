<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecalculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recalculo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tipo_recalculo')->unsigned();
            $table->foreign('id_tipo_recalculo')->references('id')->on('tipo_recalculo')->onDelete('cascade');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('cascade');
            $table->string('status')->default('novo');
            $table->text('descricao')->nullable();
            $table->string('guia')->nullable();
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
        Schema::dropIfExists('recalculo');
    }
}
