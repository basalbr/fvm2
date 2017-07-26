<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Chamado;
use App\Models\Config;
use App\Models\TipoChamado;
use App\Services\CreateChamado;
use App\Services\FinishChamado;
use App\Services\ReopenChamado;
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
        $chamado = Chamado::findOrFail($idChamado);
        $tiposChamado = TipoChamado::orderBy('descricao')->get();
        return view('admin.chamado.view.index', compact('chamado', 'tiposChamado'));
    }

    public function finish($idChamado)
    {
        $chamado = Chamado::findOrFail($idChamado);
        if (FinishChamado::handle($chamado)) {
            return redirect()->route('listAtendimentosToAdmin')->with('successAlert', 'Chamado finalizado com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function reopen($idChamado)
    {
        $chamado = Chamado::findOrFail($idChamado);
        if (ReopenChamado::handle($chamado)) {
            return redirect()->route('listAtendimentosToAdmin')->with('successAlert', 'Chamado reaberto com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

}
