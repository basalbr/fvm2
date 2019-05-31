<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Cadastro;

use App\Models\TipoAlteracao;
use App\Services\CreateNoticia;
use App\Services\CreateTipoAlteracao;
use App\Services\UpdateTipoAlteracao;
use App\Validation\TipoAlteracaoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TipoAlteracaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $alteracoes = TipoAlteracao::orderBy('descricao')->get();
        return view('admin.cadastro.alteracao.index', compact('alteracoes'));
    }

    public function new()
    {
        return view('admin.cadastro.alteracao.new.index');
    }

    public function view($id)
    {
        $alteracao = TipoAlteracao::findOrFail($id);
        return view('admin.cadastro.alteracao.view.index', compact('alteracao'));
    }

    public function store(Request $request)
    {
        if (CreateTipoAlteracao::handle($request)) {
            return redirect()->route('listCadastroAlteracao')->with('successAlert', 'Tipo de alteração cadastrado com sucesso');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function update(Request $request, $id)
    {
        if (UpdateTipoAlteracao::handle($request, $id)) {
            return redirect()->route('listCadastroAlteracao')->with('successAlert', 'Tipo de alteração editado com sucesso');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * @param Request $request
     */
    public function validateTipoAlteracao(Request $request)
    {
        $this->validate($request, TipoAlteracaoValidation::getRules(), [], TipoAlteracaoValidation::getNiceNames());
    }


}
