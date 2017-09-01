<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMensalidadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mensalidade', function (Blueprint $table) {
            $table->integer('qtde_documento_contabil')->nullable()->change();
            $table->integer('qtde_pro_labore')->nullable()->change();
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
            //
        });
    }
}
