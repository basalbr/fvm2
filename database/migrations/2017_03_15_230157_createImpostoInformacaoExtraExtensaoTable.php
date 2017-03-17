<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpostoInformacaoExtraExtensaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imposto_informacao_extra_extensao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_informacao_extra')->unsigned();
            $table->foreign('id_informacao_extra')->references('id')->on('informacao_extra')->onDelete('cascade');
            $table->string('extensao');
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
        Schema::dropIfExists('imposto_informacao_extra_extensao');
    }
}
