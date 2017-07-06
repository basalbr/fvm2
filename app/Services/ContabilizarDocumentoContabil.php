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
use App\Models\ProcessoDocumentoContabil;
use App\Models\Usuario;
use App\Notifications\EmpresaActivated;
use App\Notifications\NewFuncionario;
use App\Notifications\ProcessoDocumentoContabilFinished;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ContabilizarDocumentoContabil
{

    /**
     * @param ProcessoDocumentoContabil $processo
     * @return bool
     */
    public static function handle(ProcessoDocumentoContabil $processo)
    {
        DB::beginTransaction();
        try {
            $processo->status = 'concluido';
            $processo->empresa->usuario->notify(new ProcessoDocumentoContabilFinished($processo));
            $processo->save();
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}