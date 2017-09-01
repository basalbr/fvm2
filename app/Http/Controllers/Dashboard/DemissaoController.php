<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\Demissao;
use App\Models\Empresa;
use App\Services\CreateDemissaoRequest;
use App\Services\SendPontos;
use App\Validation\DemissaoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DemissaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $demissoesPendentes = Demissao::join('funcionario', 'funcionario.id', 'demissao.id_funcionario')
            ->join('empresa', 'empresa.id', 'funcionario.id_empresa')
            ->join('usuario', 'usuario.id', 'empresa.id_usuario')
            ->where('usuario.id', Auth::user()->id)
            ->where('demissao.status', 'pendente')
            ->orderBy('demissao.created_at', 'desc')
            ->select('demissao.*')
            ->get();

        $demissoesConcluidas = Demissao::join('funcionario', 'funcionario.id', 'demissao.id_funcionario')
            ->join('empresa', 'empresa.id', 'funcionario.id_empresa')
            ->join('usuario', 'usuario.id', 'empresa.id_usuario')
            ->where('usuario.id', Auth::user()->id)
            ->where('demissao.status', 'concluido')
            ->orderBy('demissao.created_at', 'desc')
            ->select('demissao.*')
            ->get();
        return view('dashboard.demissao.index', compact('demissoesPendentes', 'demissoesConcluidas'));
    }

    public function new($idFuncionario)
    {
        $funcionario = Auth::user()->funcionarios()->findOrFail($idFuncionario);
        return view('dashboard.demissao.new.index', compact('funcionario'));
    }

    public function view($idDemissao)
    {
        $demissao = Demissao::findOrFail($idDemissao);
        if ($demissao->funcionario->empresa->usuario->id == Auth::user()->id) {
            return view('dashboard.demissao.view.index', compact('demissao'));
        }
        return false;
    }

    public function store($idFuncionario, Request $request)
    {
        Auth::user()->funcionarios()->findOrFail($idFuncionario);
        $request->merge(['id_funcionario' => $idFuncionario]);
        $this->validate($request, DemissaoValidation::getRules(), [], DemissaoValidation::getNiceNames());
        if (CreateDemissaoRequest::handle($request)) {
            return redirect()->route('listDemissaoToUser')->with('successAlert', 'Seu pedido de demissão foi enviado com sucesso!');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function validateDemissao(Request $request)
    {
        $request->merge(['id_funcionario' => 1]);
        $this->validate($request, DemissaoValidation::getRules(), [], DemissaoValidation::getNiceNames());
    }


}
