<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

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

class ChamadoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function store(Request $request)
    {
        $this->validate($request, ChamadoValidation::getRules(), [], ChamadoValidation::getNiceNames());
        if (CreateChamado::handle($request)) {
            return redirect()->route('listAtendimentosToUser')->with('successAlert', 'Seu chamado foi aberto com sucesso, você receberá uma notificação assim que respondermos :)');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function view($idChamado)
    {
        $chamado = Auth::user()->chamados()->find($idChamado);
        $tiposChamado = TipoChamado::orderBy('descricao')->get();
        return view('admin.chamado.view.index', compact('chamado', 'tiposChamado'));
    }

}
