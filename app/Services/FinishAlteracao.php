<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Alteracao;
use App\Models\OrdemPagamento;
use App\Models\Usuario;
use App\Notifications\NewSolicitacaoAlteracao;
use App\Notifications\SolicitacaoAlteracaoFinished;
use Illuminate\Http\Request;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FinishAlteracao
{

    public static function handle($idAlteracao)
    {
        DB::beginTransaction();
        try {
            /* @var Alteracao $alteracao */
            $alteracao = Alteracao::findOrFail($idAlteracao);
            $alteracao->status = 'concluido';
            $alteracao->save();

            $alteracao->usuario->notify(new SolicitacaoAlteracaoFinished($alteracao));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}