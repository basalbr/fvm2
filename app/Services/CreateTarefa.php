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
use App\Models\Usuario;
use App\Notifications\TarefaCreated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateTarefa
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            /* @var $tarefa Tarefa */
            $data = Carbon::createFromFormat('d/m/Y', $request->get('data'))->format('Y-m-d') . ' ' . $request->get('hora') . ':00';
            $responsavel = Usuario::findOrFail($request->get('responsavel'));

            $tarefa = Tarefa::create([
                'assunto' => $request->get('assunto'),
                'mensagem' => $request->get('mensagem'),
                'expectativa_conclusao_em' => $data,
                'status' => 'pendente'
            ]);
            $tarefa->usuarios()->create(['id_usuario' => $responsavel->id, 'funcao' => 'responsavel']);
            $tarefa->usuarios()->create(['id_usuario' => Auth::user()->id, 'funcao' => 'criador']);

            /* @var $responsavel Usuario */
            $responsavel->notify(new TarefaCreated($tarefa));

            RegistroAtividade::create([
                'id_usuario' => Auth::user()->id,
                'id_referencia' => $tarefa->id,
                'referencia' => 'tarefa',
                'mensagem' => Auth::user()->nome . ' criou uma tarefa para ' . $responsavel->nome
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