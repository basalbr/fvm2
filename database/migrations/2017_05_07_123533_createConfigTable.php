<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->double('valor_abertura_empresa')->default(79.9);
            $table->double('valor_incremental_funcionario')->default(25);
            $table->string('email_admin')->default('admin@webcontabilidade.com');
            $table->string('email_contato')->default('contato@webcontabilidade.com');
            $table->string('email_bugs')->default('bugs@webcontabilidade.com');
            $table->string('whatsapp', 16)->default('(47) 9 9915-9716');
            $table->string('facebook')->default('https://www.facebook.com/WEBContabilidade-1762521307351768');
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
        Schema::dropIfExists('config');
    }
}
