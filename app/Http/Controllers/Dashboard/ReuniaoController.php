<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\ReuniaoHorario;
use App\Services\CreateReuniao;
use App\Validation\ReuniaoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ReuniaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $reunioes = Auth::user()->reunioes()->orderBy('data')->get();
        $horarios = ReuniaoHorario::orderBy('hora_inicial')->get();
        return view('dashboard.reunioes.index', compact('reunioes', 'horarios'));
    }

    public function view($idReuniao)
    {
        $reuniao = Auth::user()->reunioes()->findOrFail($idReuniao);
        return view('dashboard.reunioes.view.index', compact('reuniao'));
    }

    public function store(Request $request)
    {
        $this->validate($request, ReuniaoValidation::getRules(), [], ReuniaoValidation::getNiceNames());
        if (CreateReuniao::handle($request)) {
            return redirect()->route('listReunioesToUser')->with('successAlert', 'Recebemos sua solicitação de reunião, ela será analisada e confirmada pela nossa equipe e você será notificado quando isso ocorrer :)');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * Valida uma request vinda de uma chamada json
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateAjax(Request $request)
    {
        $this->validate($request, ReuniaoValidation::getRules(), [], ReuniaoValidation::getNiceNames());
        return response()->json('success', 200);
    }

}
