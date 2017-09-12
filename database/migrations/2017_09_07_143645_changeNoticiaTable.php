<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNoticiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('noticia', function (Blueprint $table) {
            $table->dropColumn('imagem', 'texto');
            $table->string('titulo_destaque');
            $table->string('subtitulo')->nullable();
            $table->string('slug');
            $table->string('capa');
            $table->date('data_publicacao');
            $table->text('conteudo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('noticia', function (Blueprint $table) {
            $table->dropColumn('titulo_destaque', 'subtitulo', 'slug', 'capa', 'data_publicacao', 'conteudo');
        });
    }
}
