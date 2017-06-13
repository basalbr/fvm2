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
use App\Models\Usuario;
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

            if (count($request->get('anexos'))) {
                foreach ($request->get('anexos') as $file) {
                    /** @var UploadedFile $file ['arquivo'] */
                    $filename = md5(random_bytes(5)) . $request->get('nome') . '.' . $file['arquivo']->getClientOriginalExtension();
                    $file['arquivo']->storeAs('anexos/' . Auth::user()->id, $filename, 'public');
                    Anexo::create([
                        'referencia' => $chamado->getTable(),
                        'id_referencia' => $chamado->id,
                        'descricao' => $file->descricao,
                        'arquivo' => $filename
                    ]);
                }
            }

            //Notifica admins que existe um novo funcionario cadastrado
            Usuario::notifyAdmins(new NewChamado($chamado));
            DB::commit();

        } catch (\Exception $e) {
            if (isset($file)) {
                Storage::disk('public')->getDriver()->delete('anexos/' . Auth::user()->id . '/' . $filename);
            }
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}