<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\GrauInstrucao;
use App\Models\Uf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class FuncionarioController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $funcionarios = Auth::user()->funcionarios;
        $empresas = Auth::user()->empresas;
        return view('dashboard.funcionario.index', compact("funcionarios", "empresas"));
    }

    public function new($empresaId)
    {
//precisa criar autorizacao
        $empresa = Auth::user()->empresas()->find($empresaId);
        $ufs = Uf::all();
        $grausInstrucao = GrauInstrucao::all();

        return view('dashboard.funcionario.new.index', compact('empresa', 'grausInstrucao','ufs'));

    }

    public function validateFuncionario(Request $request)
    {

    }

}
