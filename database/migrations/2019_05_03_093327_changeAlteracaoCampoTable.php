<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAlteracaoCampoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alteracao_campo', function (Blueprint $table) {
            $table->boolean('obrigatorio')->default(false);
            $table->boolean('ativo')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alteracao_campo', function (Blueprint $table) {
            $table->dropColumn(['obrigatorio','ativo']);
        });
    }
}
