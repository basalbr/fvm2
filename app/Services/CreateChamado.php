<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Anexo;
use App\Models\Chamado;
use App\Models\ContratoTrabalho;
use App\Models\Mensagem;
use App\Models\Usuario;
use App\Notifications\NewChamado;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CreateChamado
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            /** @var Chamado $chamado */
            $chamado = Auth::user()->chamados()->create($request->all());
            Mensagem::create([
                'id_referencia' => $chamado->id,
                'referencia' => $chamado->getTable(),
                'from_admin' => Auth::user()->admin,
                'mensagem' => $request->get('mensagem'),
                'id_usuario' => Auth::user()->id
            ]);
            if ($request->has('anexos')) {
                foreach ($request->get('anexos') as $arquivo) {
                    Anexo::create([
                        'id_referencia' => $chamado->id,
                        'referencia' => $chamado->getTable(),
                        'arquivo' => $arquivo['arquivo'],
                        'descricao' => $arquivo['descricao']
                    ]);
                    Storage::move('temp/' . $arquivo['arquivo'], 'public/anexos/' . $chamado->getTable() . '/' . $chamado->id . '/' . $arquivo['arquivo']);
                }
            }

            //Notifica admins que existe um novo funcionario cadastrado
            Usuario::notifyAdmins(new NewChamado($chamado));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}