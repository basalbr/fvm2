<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Apuracao;
use App\Models\Mensagem;
use App\Services\UpdateApuracao;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApuracaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($idApuracao)
    {
        /* @var Apuracao $apuracao */
        $apuracao = Apuracao::find($idApuracao);
        $qtdeDocumentos = $apuracao->informacoes()
            ->join('imposto_informacao_extra', 'imposto_informacao_extra.id', 'apuracao_informacao_extra.id_informacao_extra')
            ->where('imposto_informacao_extra.tipo', 'anexo')
            ->count();
        $qtdeDocumentos += Mensagem::join('anexo', 'anexo.id_referencia', 'mensagem.id')
            ->where('anexo.referencia', 'mensagem')
            ->where('mensagem.referencia', 'apuracao')
            ->where('mensagem.id_referencia', $idApuracao)
            ->count();
        $qtdeDocumentos += $apuracao->anexos()->count();
        return view('admin.apuracao.view.index', compact('apuracao', 'qtdeDocumentos'));
    }

    public function index(Request $request)
    {
        $apuracoesPendentes = Apuracao::query()->whereIn('apuracao.status', ['informacoes_enviadas', 'novo', 'atencao']);
        if (!$request->has('tab') || $request->get('tab') == 'pendentes') {
            $apuracoesPendentes = $this->filterForm($apuracoesPendentes, $request);
        }
        $qtdApuracoes = $apuracoesPendentes->select('apuracao.*')->count();
        $apuracoesPendentes = $apuracoesPendentes->select('apuracao.*')->paginate(10);


        $apuracoesConcluidas = Apuracao::query()->whereNotIn('apuracao.status', ['informacoes_enviadas', 'novo', 'atencao']);
        if (!$request->has('tab') || $request->get('tab') == 'historico') {
            $apuracoesConcluidas = $this->filterForm($apuracoesConcluidas, $request);
        }
        $apuracoesConcluidas = $apuracoesConcluidas->select('apuracao.*')->paginate(10);

        return view('admin.apuracao.index', compact('apuracoesConcluidas', 'apuracoesPendentes', 'qtdApuracoes'));
    }

    public function validateGuia(Request $request)
    {
        $rules = ['arquivo' => 'max:10240|required|file|mimes:pdf'];
        $niceNames = ['arquivo' => 'Guia'];
        $this->validate($request, $rules, [], $niceNames);
    }

    public function update(Request $request, $idApuracao)
    {
        if (UpdateApuracao::handle($request, $idApuracao)) {
            return redirect()->route('showApuracaoToAdmin', [$idApuracao])->with('successAlert', 'Apuração atualizada com sucesso.');
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
        $query->join('empresa', 'empresa.id', '=', 'apuracao.id_empresa')->join('usuario', 'usuario.id', '=', 'empresa.id_usuario');
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
        if ($request->get('imposto')) {
            $query->where('apuracao.id_imposto', $request->get('imposto'));
        }
        if ($request->get('status')) {
            $query->where('apuracao.status', $request->get('status'));
        }
        if ($request->get('de')) {
            $data = explode('/', $request->get('de'));
            $query->where('apuracao.competencia', '>=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('ate')) {
            $data = explode('/', $request->get('ate'));
            $query->where('apuracao.competencia', '<=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('ordenar')) {
            switch ($request->get('ordenar')) {
                case 'periodo_asc':
                    $query->orderBy('apuracao.competencia');
                    break;
                case 'periodo_desc':
                    $query->orderBy('apuracao.competencia', 'desc');
                    break;
                case 'empresa_asc':
                    $query->orderBy('empresa.nome');
                    break;
                case 'empresa_desc':
                    $query->orderBy('empresa.nome', 'desc');
                    break;
                case 'razao_social_asc':
                    $query->orderBy('empresa.razao_social');
                    break;
                case 'razao_social_desc':
                    $query->orderBy('empresa.razao_social', 'desc');
                    break;
                default:
                    $query->orderBy('apuracao.competencia');
            }
        } else {
            $query->orderBy('apuracao.competencia', 'desc');
        }
        return $query;
    }

}
