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
use App\Notifications\ChamadoFinished;
use App\Notifications\NewChamado;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FinishChamado
{

    public static function handle(Chamado $chamado)
    {
        DB::beginTransaction();
        try {
            /** @var Chamado $chamado */
            $chamado->update(['status'=>'Concluído']);

            //Notifica admins que existe um novo funcionario cadastrado
            $chamado->usuario->notify(new ChamadoFinished($chamado));

            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}