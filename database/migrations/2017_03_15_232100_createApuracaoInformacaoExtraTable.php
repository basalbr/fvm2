<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApuracaoInformacaoExtraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apuracao_informacao_extra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_apuracao')->unsigned();
            $table->foreign('id_apuracao')->references('id')->on('apuracao')->onDelete('cascade');
            $table->integer('id_informacao_extra')->unsigned();
            $table->foreign('id_informacao_extra')->references('id')->on('imposto_informacao_extra')->onDelete('cascade');
            $table->string('informacao');
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
        Schema::dropIfExists('processo_informacao_extra');
    }
}
