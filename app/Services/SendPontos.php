<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\ContratoTrabalho;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\FuncionarioContrato;
use App\Models\FuncionarioDeficiencia;
use App\Models\Mensalidade;
use App\Models\OrdemPagamento;
use App\Models\Ponto;
use App\Models\Usuario;
use App\Notifications\EmpresaActivated;
use App\Notifications\FuncionarioActivated;
use App\Notifications\NewFuncionario;
use App\Notifications\PontosSent;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendPontos
{
    /**
     * @param int $id
     * @return bool
     */
    public static function handle($id)
    {
        DB::beginTransaction();
        try {
            $ponto = Auth::user()->pontos()->findOrFail($id);
            /* @var Ponto $ponto */
            $ponto->status = 'informacoes_enviadas';
            $ponto->save();
            //Notifica admins que existe um novo funcionario cadastrado
            $ponto->empresa->usuario->notify(new PontosSent($ponto));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}