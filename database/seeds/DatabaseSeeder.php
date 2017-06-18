<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoriaContratoTrabalho = DB::table('categoria_contrato_trabalho');
        $categoriaContratoTrabalho->insert(['descricao' => 'Mensalista']);
        $categoriaContratoTrabalho->insert(['descricao' => 'Semanalista']);
        $categoriaContratoTrabalho->insert(['descricao' => 'Diarista']);
        $categoriaContratoTrabalho->insert(['descricao' => 'Horista']);
        $categoriaContratoTrabalho->insert(['descricao' => 'Tarefeiro']);
        $categoriaContratoTrabalho->insert(['descricao' => 'Comissionado']);

    }
}
