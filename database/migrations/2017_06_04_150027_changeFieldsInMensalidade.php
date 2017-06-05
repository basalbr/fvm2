<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsInMensalidade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mensalidade', function (Blueprint $table) {
            $table->dropColumn(['duracao', 'dia_pagamento']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mensalidade', function (Blueprint $table) {
            $table->integer('duracao');
            $table->integer('dia_pagamento');
        });
    }
}
