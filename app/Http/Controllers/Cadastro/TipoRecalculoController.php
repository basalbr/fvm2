<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Cadastro;

use App\Models\TipoRecalculo;
use App\Services\CreateTipoRecalculo;
use App\Services\UpdateTipoRecalculo;
use App\Validation\TipoRecalculoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TipoRecalculoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $recalculos = TipoRecalculo::orderBy('descricao')->get();
        return view('admin.cadastro.recalculo.index', compact('recalculos'));
    }

    public function new()
    {
        return view('admin.cadastro.recalculo.new.index');
    }

    public function view($id)
    {
        $recalculo = TipoRecalculo::findOrFail($id);
        return view('admin.cadastro.recalculo.view.index', compact('recalculo'));
    }

    public function store(Request $request)
    {
        if (CreateTipoRecalculo::handle($request)) {
            return redirect()->route('listCadastroRecalculo')->with('successAlert', 'Tipo de recálculo cadastrado com sucesso');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function update(Request $request, $id)
    {
        if (UpdateTipoRecalculo::handle($request, $id)) {
            return redirect()->route('listCadastroRecalculo')->with('successAlert', 'Tipo de recálculo editado com sucesso');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * @param Request $request
     */
    public function validateAjax(Request $request)
    {
        $this->validate($request, TipoRecalculoValidation::getRules(), [], TipoRecalculoValidation::getNiceNames());
    }


}
