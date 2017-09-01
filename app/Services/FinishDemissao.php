<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Anexo;
use App\Models\Demissao;
use App\Models\ContratoTrabalho;
use App\Models\Mensagem;
use App\Models\Usuario;
use App\Notifications\DemissaoFinished;
use App\Notifications\NewDemissao;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FinishDemissao
{

    public static function handle(Demissao $demissao)
    {
        DB::beginTransaction();
        try {
            /** @var Demissao $demissao */
            $demissao->update(['status'=>'concluido']);

            //Notifica admins que existe um novo funcionario cadastrado
            $demissao->funcionario->empresa->usuario->notify(new DemissaoFinished($demissao));

            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}