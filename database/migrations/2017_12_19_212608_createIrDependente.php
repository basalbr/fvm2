<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIrDependente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ir_dependente', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_imposto_renda')->unsigned();
            $table->foreign('id_imposto_renda')->references('id')->on('imposto_renda')->onDelete('cascade');
            $table->integer('id_ir_tipo_dependente')->unsigned();
            $table->foreign('id_ir_tipo_dependente')->references('id')->on('ir_tipo_dependente')->onDelete('cascade');
            $table->string('nome')->nullable();
            $table->date('data_nascimento')->nullable();
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
        Schema::dropIfExists('ir_dependente');
    }
}
