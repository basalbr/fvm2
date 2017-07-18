<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Alteracao;
use App\Models\TipoAlteracao;
use App\Services\CancelAlteracao;
use App\Services\CreateSolicitacaoAlteracao;
use App\Services\FinishAlteracao;
use App\Validation\AlteracaoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AlteracaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /* Query pending alterations */
        $alteracoesPendentes = Alteracao::query()->whereIn('alteracao.status', ['Pendente', 'Atencao']);
        if (!$request->has('tab') || $request->get('tab') == 'pendentes') {
            $alteracoesPendentes = $this->filterForm($alteracoesPendentes, $request);
        }
        $alteracoesPendentes = $alteracoesPendentes->select('alteracao.*')->get();

        /* Query finished alterations */
        $alteracoesConcluidas = Alteracao::query()->whereIn('alteracao.status', ['Concluído', 'Cancelado']);
        if ($request->get('tab') == 'historico') {
            $alteracoesConcluidas = $this->filterForm($alteracoesConcluidas, $request);
        }
        $alteracoesConcluidas = $alteracoesConcluidas->select('alteracao.*')->get();

        /* Return view */
        return view('admin.alteracao.index', compact('alteracoesPendentes', 'alteracoesConcluidas'));
    }

    /**
     * @param $idAlteracao
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($idAlteracao)
    {
        $alteracao = Alteracao::findOrFail($idAlteracao);
        return view('admin.alteracao.view.index', compact('alteracao', 'idAlteracao'));
    }

    /**
     * @param $idAlteracao
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish($idAlteracao)
    {
        if (FinishAlteracao::handle($idAlteracao)) {
            return redirect()->route('listSolicitacoesAlteracaoToAdmin')->with('successAlert', 'Alteração concluída com sucesso ;)');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function cancel($idAlteracao)
    {
        if (CancelAlteracao::handle($idAlteracao)) {
            return redirect()->route('listSolicitacoesAlteracaoToAdmin')->with('successAlert', 'Alteração cancelada com sucesso :O');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function validateAlteracao(Request $request)
    {
        $this->validate($request, AlteracaoValidation::getRules(), [], AlteracaoValidation::getNiceNames());
    }

    public function filterForm($query, $request)
    {
        $query->join('usuario', 'alteracao.id_usuario', '=', 'usuario.id')
            ->join('empresa', 'alteracao.id_empresa', '=', 'empresa.id');
        if ($request->get('tipo')) {
            $query->where('alteracao.id_tipo_alteracao', $request->get('tipo'));
        }
        if ($request->get('empresa')) {
            $query->where(function ($q) use ($request) {
                $q->where('empresa.nome_fantasia', 'LIKE', '%' . $request->get('empresa') . '%')
                    ->orWhere('empresa.razao_social', 'LIKE', '%' . $request->get('empresa') . '%')
                    ->orWhere('empresa.cnpj', 'LIKE', '%' . $request->get('empresa') . '%');
            });
        }
        if ($request->get('usuario')) {
            $query->$query->where(function ($q) use ($request) {
                $q->where('usuario.nome', 'LIKE', '%' . $request->get('usuario') . '%')
                    ->orWhere('usuario.email', 'LIKE', '%' . $request->get('usuario') . '%');
            });
        }
        if ($request->get('ordenar')) {
            switch ($request->get('ordenar')) {
                case 'criado_asc':
                    $query->orderBy('alteracao.created_at');
                    break;
                case 'criado_desc':
                    $query->orderBy('alteracao.created_at', 'desc');
                    break;
                case 'empresa_asc':
                    $query->orderBy('empresa.nome_fantasia');
                    break;
                case 'empresa_desc':
                    $query->orderBy('empresa.nome_fantasia', 'desc');
                    break;
                case 'usuario_asc':
                    $query->orderBy('usuario.nome');
                    break;
                case 'usuario_desc':
                    $query->orderBy('usuario.nome', 'desc');
                    break;
                default:
                    $query->orderBy('alteracao.created_at', 'desc');
            }
        }
        return $query;
    }

}
