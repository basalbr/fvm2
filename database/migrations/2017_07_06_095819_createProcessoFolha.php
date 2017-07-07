<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessoFolha extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processo_folha', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->foreign('id_empresa')->references('id')->on('empresa')->onDelete('cascade');
            $table->string('irrf')->nullable();
            $table->string('inss')->nullable();
            $table->string('recibo_folha')->nullable();
            $table->string('fgts')->nullable();
            $table->date('competencia');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processo_folha');
    }
}
