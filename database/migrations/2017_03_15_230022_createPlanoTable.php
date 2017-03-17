<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plano', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('duracao')->unsigned();
            $table->float('valor');
            $table->string('nome');
            $table->text('descricao');
            $table->integer('total_documento_fiscal');
            $table->integer('total_pro_labore');
            $table->integer('total_funcionario');
            $table->integer('total_documento_contabil');
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
        Schema::dropIfExists('plano');
    }
}
