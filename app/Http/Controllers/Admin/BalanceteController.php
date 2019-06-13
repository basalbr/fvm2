<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Apuracao;
use App\Models\Balancete;
use App\Models\Empresa;
use App\Services\SendBalancete;
use App\Services\UpdateApuracao;
use App\Validation\BalanceteValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BalanceteController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($id)
    {
        /* @var Balancete $balancete */
        $balancete = Balancete::findOrFail($id);
        return view('admin.balancete.view.index', compact('balancete'));
    }

    public function create($id = null)
    {
        /* @var Empresa $empresas */
        $empresas = Empresa::where('status', 'aprovado')->orderBy('razao_social')->get();
        return view('admin.balancete.new.index', compact('empresas', 'id'));
    }

    public function delete($id)
    {
        /* @var Balancete $balancete */
        $balancete = Balancete::findOrFail($id);
        $balancete->delete();
        return redirect()->route('listBalancetesToAdmin')->with('successAlert', 'Balancete removido com sucesso.');
    }

    public function store(Request $request)
    {
        if (SendBalancete::handle($request)) {
            return redirect()->route('newBalancete', [$request->get('id_empresa')])->with('successAlert', 'Balancete enviado com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function history($id)
    {
        $balancetes = Balancete::where('id_empresa', $id)->orderBy('exercicio', 'desc')->limit(12)->get();
        return view('admin.balancete.history.index', compact('balancetes'));
    }

    public function index(Request $request)
    {
        $balancetes = $this->filterForm(Balancete::query(), $request)->paginate(10);
        return view('admin.balancete.index', compact('balancetes'));
    }

    public function validateBalancete(Request $request)
    {
        $this->validate($request, BalanceteValidation::getRules(), [], BalanceteValidation::getNiceNames());
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
        $query->join('empresa', 'empresa.id', '=', 'balancete.id_empresa')->join('usuario', 'usuario.id', '=', 'empresa.id_usuario');
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
        if ($request->get('exercicio_de')) {
            $data = explode('/', $request->get('exercicio_de'));
            $query->where('balancete.exercicio', '>=', $data[1] . '-' . $data[0] . '-01');
        }
        if ($request->get('exercicio_ate')) {
            $data = explode('/', $request->get('exercicio_ate'));
            $query->where('balancete.exercicio', '<=', $data[1] . '-' . $data[0] . '-01');
        }
        if ($request->get('ordenar')) {
            switch ($request->get('ordenar')) {
                case 'exercicio_asc':
                    $query->orderBy('balancete.exercicio');
                    break;
                case 'exercicio_desc':
                    $query->orderBy('balancete.exercicio', 'desc');
                    break;
                case 'empresa_asc':
                    $query->orderBy('empresa.nome');
                    break;
                case 'empresa_desc':
                    $query->orderBy('empresa.nome', 'desc');
                    break;
                case 'razao_social_asc':
                    $query->orderBy('razao_social.created_at');
                    break;
                case 'razao_social_desc':
                    $query->orderBy('razao_social.created_at', 'desc');
                    break;
                default:
                    $query->orderBy('balancete.exercicio', 'desc');
            }
        } else {
            $query->orderBy('balancete.exercicio', 'desc');
        }
        return $query->select('balancete.*');
    }

}
