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
use App\Models\Usuario;
use App\Notifications\EmpresaActivated;
use App\Notifications\NewFuncionario;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ActivateEmpresa
{

    /**
     * @param Empresa $empresa
     * @return bool
     */
    public static function handle(Empresa $empresa)
    {
        DB::beginTransaction();
        try {
            $empresa->status = 'aprovado';
            $empresa->save();

            /* @var Mensalidade $mensalidade */
            $mensalidade = $empresa->mensalidades()->latest()->first();

            OrdemPagamento::create([
                'id_referencia' => $mensalidade->id,
                'referencia' => $mensalidade->getTable(),
                'valor' => $mensalidade->valor,
                'vencimento' => date('Y-m-d H:i:s', strtotime("+5 days")),
                'status' => 'Pendente',
                'id_usuario'=> $empresa->id_usuario
            ]);

            $mensalidade->status = 'Aprovado';
            $mensalidade->created_at = date('Y-m-d H:i:s');
            $mensalidade->save();

            //Notifica admins que existe um novo funcionario cadastrado
            $empresa->usuario->notify(new EmpresaActivated($empresa));
            $empresa->abrirApuracoes();
            $empresa->abrirProcessosDocumentosContabeis();
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}