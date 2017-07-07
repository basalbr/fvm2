<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\Empresa;
use App\Models\ProcessoFolha;
use App\Services\SendProcessoFolha;
use App\Services\UpdateApuracao;
use App\Validation\ProcessoFolhaValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;

class ProcessoFolhaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $historicoFolha = ProcessoFolha::join('empresa', 'empresa.id', 'processo_folha.id_empresa')
            ->where('empresa.id_usuario', Auth::user()->id)
            ->orderBy('processo_folha.created_at', 'desc')
            ->select('processo_folha.*')
            ->get();
        return view('dashboard.processo_folha.index', compact('historicoFolha'));
    }

    public function view($id)
    {
        $processo = ProcessoFolha::join('empresa', 'empresa.id', '=', 'processo_folha.id_empresa')
            ->where('empresa.id_usuario', Auth::user()->id)
            ->where('processo_folha.id', $id)
            ->select('processo_folha.*')
            ->firstOrFail();
        return view('dashboard.processo_folha.view.index', compact('processo'));
    }

}
