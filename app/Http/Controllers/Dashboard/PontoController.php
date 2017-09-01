<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\Empresa;
use App\Services\SendPontos;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PontoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $pontosPendentes = Auth::user()->pontos()
            ->whereIn('ponto.status', ['pendente', 'informacoes_enviadas', 'atencao'])
            ->orderBy('ponto.periodo', 'desc')
            ->get();
        $pontosConcluidos = Auth::user()->pontos()
            ->whereIn('ponto.status', ['concluido', 'sem_movimento', 'cancelado'])
            ->orderBy('ponto.periodo', 'desc')
            ->get();
        return view('dashboard.ponto.index', compact('pontosPendentes', 'pontosConcluidos'));
    }

    public function send($idPonto)
    {
        if (SendPontos::handle($idPonto)) {
            return redirect()->route('showPontoToUser', [$idPonto])->with('successAlert', 'Nós recebemos suas informações e em breve realizaremos a apuração. Obrigado :)');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function view($idPonto)
    {
        $ponto = Auth::user()->pontos()->findOrFail($idPonto);
        return view('dashboard.ponto.view.index', compact('ponto'));
    }


}
