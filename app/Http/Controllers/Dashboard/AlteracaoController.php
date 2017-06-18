<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\Alteracao;
use App\Models\TipoAlteracao;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AlteracaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $tiposAlteracao = TipoAlteracao::orderBy('descricao')->get();
        $alteracoes = Alteracao::orderBy('created_at', 'desc')->get();
        return view('dashboard.alteracao.index', compact("tiposAlteracao", 'alteracoes'));
    }

    public function new($idTipoAlteracao){
        $tipoAlteracao = TipoAlteracao::find($idTipoAlteracao);
        $empresas = Auth::user()->empresas()->orderBy('nome_fantasia', 'asc')->get();
        return view('dashboard.alteracao.new.index', compact('tipoAlteracao', 'empresas'));
    }

}
