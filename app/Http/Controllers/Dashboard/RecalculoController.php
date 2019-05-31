<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\TipoAlteracao;
use App\Models\TipoRecalculo;
use App\Services\CreateRecalculo;
use App\Services\CreateSolicitacaoAlteracao;
use App\Validation\RecalculoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class RecalculoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $recalculos = Auth::user()->recalculos()->paginate(10);
        return view('dashboard.recalculo.index', compact('recalculos'));
    }

    public function new()
    {
        $tipos = TipoRecalculo::orderBy('descricao')->get();
        return view('dashboard.recalculo.new.index', compact('tipos'));
    }

    public function view($id)
    {
        $recalculo = Auth::user()->recalculos()->find($id);
        return view('dashboard.recalculo.view.index', compact('recalculo'));
    }

    public function store(Request $request)
    {
        $this->validate($request, RecalculoValidation::getRules(), [], RecalculoValidation::getNiceNames());
        if (CreateRecalculo::handle($request)) {
            return redirect()->route('listRecalculosToUser')->with('successAlert', 'Recebemos sua solicitação de recálculo, fique atento ao seu e-mail pois você receberá uma notificação assim que tivermos novidades :)');
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
        $this->validate($request, RecalculoValidation::getRules(), [], RecalculoValidation::getNiceNames());
        return response()->json('success', 200);
    }

}
