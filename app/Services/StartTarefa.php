<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\RegistroAtividade;
use App\Models\Tarefa;
use App\Models\TarefaUsuario;
use App\Models\Usuario;
use App\Notifications\TarefaStarted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StartTarefa
{

    public static function handle(Tarefa $tarefa)
    {
        DB::beginTransaction();
        try {
            $tarefa->status = 'em_execucao';
            $tarefa->save();
            $tarefa_criador = TarefaUsuario::where('id_tarefa', $tarefa->id)->where('funcao', 'criador')->first();
            $criador = Usuario::findOrFail($tarefa_criador->id_usuario);
            $criador->notify(new TarefaStarted($tarefa));
            RegistroAtividade::create([
                'id_usuario' => Auth::user()->id,
                'id_referencia' => $tarefa->id,
                'referencia' => 'tarefa',
                'mensagem' => Auth::user()->nome . ' iniciou a tarefa'
            ]);
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}