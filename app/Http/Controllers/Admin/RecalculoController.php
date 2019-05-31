<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Recalculo;
use App\Models\Mensagem;
use App\Services\UpdateRecalculo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RecalculoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($idRecalculo)
    {
        /* @var Recalculo $recalculo */
        $recalculo = Recalculo::find($idRecalculo);
        $qtdeDocumentos = Mensagem::join('anexo', 'anexo.id_referencia', 'mensagem.id')
            ->where('anexo.referencia', 'mensagem')
            ->where('mensagem.referencia', 'recalculo')
            ->where('mensagem.id_referencia', $idRecalculo)
            ->count();
        return view('admin.recalculo.view.index', compact('recalculo', 'qtdeDocumentos'));
    }

    public function index(Request $request)
    {
        $recalculosPendentes = Recalculo::query()->whereIn('recalculo.status', ['novo', 'pendente']);
        if (!$request->has('tab') || $request->get('tab') == 'pendentes') {
            $recalculosPendentes = $this->filterForm($recalculosPendentes, $request);
        }
        $qtdApuracoes = $recalculosPendentes->select('recalculo.*')->count();
        $recalculosPendentes = $recalculosPendentes->select('recalculo.*')->paginate(10);


        $recalculosConcluidos = Recalculo::query()->whereNotIn('recalculo.status', ['novo', 'pendente']);
        if (!$request->has('tab') || $request->get('tab') == 'historico') {
            $recalculosConcluidos = $this->filterForm($recalculosConcluidos, $request);
        }
        $recalculosConcluidos = $recalculosConcluidos->select('recalculo.*')->paginate(10);

        return view('admin.recalculo.index', compact('recalculosConcluidos', 'recalculosPendentes', 'qtdApuracoes'));
    }

    public function validateGuia(Request $request)
    {
        $rules = ['arquivo' => 'max:10240|required|file|mimes:pdf'];
        $niceNames = ['arquivo' => 'Guia'];
        $this->validate($request, $rules, [], $niceNames);
    }

    public function update(Request $request, $idRecalculo)
    {
        if (UpdateRecalculo::handle($request, $idRecalculo)) {
            return redirect()->route('showRecalculoToAdmin', [$idRecalculo])->with('successAlert', 'Recálculo atualizado com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function filterForm($query, $request)
    {
        $query->join('usuario', 'usuario.id', '=', 'recalculo.id_usuario')
            ->join('tipo_recalculo', 'recalculo.id_tipo_recalculo', '=', 'tipo_recalculo.id');
        if ($request->get('busca')) {
            $query->where(function ($q) use ($request) {
                $q->where('usuario.nome', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('usuario.telefone', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('usuario.email', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('empresa.nome_fantasia', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('empresa.razao_social', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('empresa.cnpj', 'LIKE', '%' . $request->get('busca') . '%');
            });
        }
        if ($request->get('tipo')) {
            $query->where('recalculo.id_tipo_recalculo', $request->get('tipo'));
        }
        if ($request->get('status')) {
            $query->where('recalculo.status', $request->get('status'));
        }
        if ($request->get('de')) {
            $data = explode('/', $request->get('de'));
            $query->where('recalculo.competencia', '>=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('ate')) {
            $data = explode('/', $request->get('ate'));
            $query->where('recalculo.competencia', '<=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('ordenar')) {
            switch ($request->get('ordenar')) {
                case 'criado_asc':
                    $query->orderBy('recalculo.created_at');
                    break;
                case 'criado_desc':
                    $query->orderBy('recalculo.created_at', 'desc');
                    break;
                case 'usuario_asc':
                    $query->orderBy('usuario.nome');
                    break;
                case 'usuario_desc':
                    $query->orderBy('usuario.nome', 'desc');
                    break;
                case 'tipo_asc':
                    $query->orderBy('tipo_recalculo.descricao');
                    break;
                case 'tipo_desc':
                    $query->orderBy('tipo_recalculo.descricao', 'desc');
                    break;
                default:
                    $query->orderBy('recalculo.created_at', 'desc');
            }
        } else {
            $query->orderBy('recalculo.created_at', 'desc');
        }
        return $query;
    }

}
