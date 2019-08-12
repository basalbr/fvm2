<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Mensagem;
use App\Models\Recalculo;
use App\Models\Reuniao;
use App\Services\UpdateRecalculo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReuniaoController extends Controller
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
        $reunioesPendentes = Reuniao::query()->whereNotIn('reuniao.status', ['concluido', 'cancelado']);
        if (!$request->has('tab') || $request->get('tab') == 'pendentes') {
            $reunioesPendentes = $this->filterForm($reunioesPendentes, $request);
        }
        $qtdReunioes = $reunioesPendentes->select('reuniao.*')->count();
        $reunioesPendentes = $reunioesPendentes->select('reuniao.*')->paginate(10);


        $reunioesRealizadas = Reuniao::query()->whereIn('reuniao.status', ['concluido', 'cancelado']);
        if (!$request->has('tab') || $request->get('tab') == 'historico') {
            $reunioesRealizadas = $this->filterForm($reunioesRealizadas, $request);
        }
        $reunioesRealizadas = $reunioesRealizadas->select('reuniao.*')->paginate(10);

        return view('admin.reuniao.index', compact('reunioesRealizadas', 'reunioesPendentes', 'qtdReunioes'));
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
        $query->join('usuario', 'usuario.id', '=', 'reuniao.id_usuario');
        if ($request->get('busca')) {
            $query->where(function ($q) use ($request) {
                $q->where('usuario.nome', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('usuario.telefone', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('usuario.email', 'LIKE', '%' . $request->get('busca') . '%');
            });
        }
        if ($request->get('status')) {
            $query->where('reuniao.status', $request->get('status'));
        }
        if ($request->get('de')) {
            $data = explode('/', $request->get('de'));
            $query->where('reuniao.data', '>=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('ate')) {
            $data = explode('/', $request->get('ate'));
            $query->where('reuniao.data', '<=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('ordenar')) {
            switch ($request->get('ordenar')) {
                case 'data_asc':
                    $query->orderBy('reuniao.data');
                    break;
                case 'data_desc':
                    $query->orderBy('reuniao.data', 'desc');
                    break;
                case 'usuario_asc':
                    $query->orderBy('usuario.nome');
                    break;
                case 'usuario_desc':
                    $query->orderBy('usuario.nome', 'desc');
                    break;
                default:
                    $query->orderBy('reuniao.data', 'asc');
            }
        } else {
            $query->orderBy('reuniao.data', 'asc');
        }
        return $query;
    }

}
