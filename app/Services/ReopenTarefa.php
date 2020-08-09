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
use App\Notifications\TarefaFinished;
use App\Notifications\TarefaReopened;
use App\Notifications\TarefaStarted;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReopenTarefa
{

    public static function handle(Tarefa $tarefa)
    {
        DB::beginTransaction();
        try {
            $tarefa->status = 'pendente';
            $tarefa->conclusao_em = null;
            $tarefa->save();
            $tarefa_responsavel = TarefaUsuario::where('id_tarefa', $tarefa->id)->where('funcao', 'responsavel')->first();
            /* @var $responsavel Usuario */
            $responsavel = Usuario::findOrFail($tarefa_responsavel->id_usuario);
            $responsavel->notify(new TarefaReopened($tarefa));
            RegistroAtividade::create([
                'id_usuario' => Auth::user()->id,
                'id_referencia' => $tarefa->id,
                'referencia' => 'tarefa',
                'mensagem' => Auth::user()->nome . ' reabriu a tarefa'
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