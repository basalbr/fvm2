<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProLaboreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_labore', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_socio')->unsigned();
            $table->foreign('id_socio')->references('id')->on('socio')->onDelete('cascade');
            $table->string('pro_labore');
            $table->string('inss');
            $table->string('irrf')->nullable();
            $table->float('valor_pro_labore');
            $table->date('competencia');
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
        Schema::dropIfExists('pro_labore');
    }
}
