<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Demissao;
use App\Services\FinishDemissao;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class DemissaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $demissoesPendentes = Demissao::where('demissao.status', 'pendente')
            ->orderBy('demissao.created_at', 'desc')
            ->select('demissao.*')
            ->get();

        $demissoesConcluidas = Demissao::where('demissao.status', 'concluido')
            ->orderBy('demissao.created_at', 'desc')
            ->select('demissao.*')
            ->get();
        return view('admin.demissao.index', compact('demissoesPendentes', 'demissoesConcluidas'));
    }

    public function view($idDemissao)
    {
        $demissao = Demissao::findOrFail($idDemissao);
            return view('admin.demissao.view.index', compact('demissao'));
    }

    public function finish($idDemissao)
    {
        $demissao = Demissao::findOrFail($idDemissao);
        if(FinishDemissao::handle($demissao)){
            return redirect()->route('listDemissaoToAdmin')->with('successAlert', 'Demissão concluída com sucesso!');
        }
        return view('admin.demissao.view.index', compact('demissao'));
    }

}
