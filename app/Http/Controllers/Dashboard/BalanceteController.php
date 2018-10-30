<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\Config;
use App\Models\TipoChamado;
use App\Services\CreateChamado;
use App\Validation\ChamadoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BalanceteController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        $balancetes = Auth::user()->balancetes()->orderBy('exercicio','desc')->orderBy('periodo_final','desc')->orderBy('periodo_inicial','desc')->get();
        return view('dashboard.balancetes.index', compact('balancetes'));
    }

    public function view($idChamado)
    {
        $chamado = Auth::user()->chamados()->find($idChamado);
        $tiposChamado = TipoChamado::orderBy('descricao')->get();
        return view('dashboard.chamado.view.index', compact('chamado', 'tiposChamado'));
    }

}
