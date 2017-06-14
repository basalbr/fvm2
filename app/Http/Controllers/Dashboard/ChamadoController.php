<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\TipoChamado;
use App\Services\CreateChamado;
use App\Validation\ChamadoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChamadoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function new()
    {
        $tiposChamado = TipoChamado::orderBy('descricao')->get();
        return view('dashboard.chamado.new.index', compact("tiposChamado"));
    }

    public function validateChamado(Request $request)
    {
        $this->validate($request, ChamadoValidation::getRules(), [], ChamadoValidation::getNiceNames());
    }

    public function store(Request $request)
    {
        $this->validate($request, ChamadoValidation::getRules(), [], ChamadoValidation::getNiceNames());
        if (CreateChamado::handle($request)) {
            return redirect()->route('listAtendimentosToUser')->with('successAlert', 'Sua solicitação de transferência de empresa foi enviada com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

}
