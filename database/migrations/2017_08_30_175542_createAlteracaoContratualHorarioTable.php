<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlteracaoContratualHorarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alteracao_contratual_horario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_alteracao_contratual')->unsigned();
            $table->foreign('id_alteracao_contratual')->references('id')->on('alteracao_contratual')->onDelete('cascade');
            $table->string('hora1')->nullable();
            $table->string('hora2')->nullable();
            $table->string('hora3')->nullable();
            $table->string('hora4')->nullable();
            $table->integer('dia');
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
        Schema::dropIfExists('alteracao_contratual_horario');
    }
}
