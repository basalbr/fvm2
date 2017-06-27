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
use Illuminate\Http\Request;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateSolicitacaoAlteracao
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            /** @var Alteracao $alteracao */
            $alteracao = Auth::user()->alteracoes()->create($request->all());
            if (count($request->get('campos'))) {
                foreach ($request->get('campos') as $idCampo => $campo) {
                    $informacao = ['id_alteracao_campo' => $idCampo, 'id_alteracao' => $alteracao->id, 'valor' => $campo];
                    $alteracao->informacoes()->create($informacao);
                }
            }

            if (count($request->file('anexos'))) {
                foreach ($request->file('anexos') as $idCampo => $file) {
                    /** @var UploadedFile $file */
                    $filename = md5(random_bytes(5)) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('anexos/alteracao/' . $alteracao->id, $filename, 'public');
                    $informacao = ['id_alteracao_campo' => $idCampo, 'id_alteracao' => $alteracao->id, 'valor' => $filename];
                    $alteracao->informacoes()->create($informacao);
                }
            }

            //Cria ordem de pagamento
            CreateOrdemPagamento::handle(Auth::user(), $alteracao->getTable(), $alteracao->id, $alteracao->tipo->valor);

            //Notifica admins que existe um novo funcionario cadastrado
            Usuario::notifyAdmins(new NewSolicitacaoAlteracao($alteracao));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}