<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTipoAlteracaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_alteracao', function (Blueprint $table) {
            $table->decimal('valor_desconto_progressivo')->default(0.0);
            $table->string('tipo_desconto_progressivo')->default('percentual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_alteracao', function (Blueprint $table) {
            $table->dropColumn(['valor_desconto_progressivo', 'tipo_desconto_progressivo']);
        });
    }
}
