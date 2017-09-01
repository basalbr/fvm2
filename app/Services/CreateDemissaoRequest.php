<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Alteracao;
use App\Models\Demissao;
use App\Models\OrdemPagamento;
use App\Models\Usuario;
use App\Notifications\NewDemissaoRequest;
use App\Notifications\NewSolicitacaoAlteracao;
use App\Validation\DemissaoValidation;
use Illuminate\Http\Request;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateDemissaoRequest
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {
           $demissao = Demissao::create($request->all());
            //Notifica admins que existe um novo funcionario cadastrado
            Usuario::notifyAdmins(new NewDemissaoRequest($demissao));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}