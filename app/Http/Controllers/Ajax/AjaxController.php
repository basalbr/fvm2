<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Ajax;

use App\Models\Cnae;
use App\Models\Plano;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AjaxController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Buscar um CNAE através do código
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchCnaeByCode(Request $request)
    {
        $rules = ['code' => 'required'];
        $this->validate($request, $rules, []);
        try {
            $cnae = Cnae::where('codigo', '=', $request->get('code'))->select('codigo', 'descricao', 'id_tabela_simples_nacional')->firstOrFail();
            /** @var Cnae $cnae */
            if ($cnae->isSimplesNacional()) {
                return response()->json($cnae, 200);
            }
            return response()->json(['message' => 'Este CNAE não é do simples nacional'], 403)->setStatusCode(403);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'CNAE não encontrado'], 404)->setStatusCode(404);
        }
    }

    /**
     * Buscar um CNAE através da descrição
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function searchCnaeByDescription(Request $request)
    {
        $rules = ['description' => 'required'];
        $this->validate($request, $rules, []);
        $cnaes = Cnae::where('descricao', 'like', '%' . $request->get('description') . '%')->select('codigo', 'descricao')->limit(5)->get();
        if ($cnaes->count()) {
            return response()->json($cnaes, 200);
        }
        return response()->json(['message' => 'Nenhum CNAE encontrado'], 404);
    }

    public function getMonthlyPaymentParams()
    {
        $planos = Plano::orderBy('total_documento_fiscal', 'asc')->get(['total_documento_fiscal', 'total_documento_contabil', 'total_funcionario', 'total_pro_labore', 'valor']);
        $maxDocsFiscais = Plano::max('total_documento_fiscal');
        $maxDocsContabeis = Plano::max('total_documento_contabil');
        $maxFuncionarios = Plano::max('total_funcionario');
        $maxProLabores = Plano::max('total_pro_labore');
        $maxPrice = Plano::max('valor');
        $minPrice = Plano::min('valor');
        return response()->json([
            'planos' => $planos,
            'maxFuncionarios' => $maxFuncionarios,
            'maxDocsFiscais' => (int)$maxDocsFiscais,
            'maxProLabores' => (int)$maxProLabores,
            'maxPrice' => (float)$maxPrice,
            'minPrice' => (int)$minPrice,
            'maxDocsContabeis' => (int)$maxDocsContabeis
        ]);
    }


}