<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

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

class ProcessoFolhaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create($idEmpresa){
        $empresa = Empresa::findOrFail($idEmpresa);
        $socios = $empresa->socios()->where('pro_labore','>',0)->orderBy('nome')->get();
        $funcionarios = $empresa->funcionarios()->where('status','ativo')->orderBy('nome_completo')->get();
        $competencia = date('Y-m-d', strtotime(date('Y-m') . " -1 month"));
        $competenciaFormatada = date('m/Y', strtotime(date('Y-m') . " -1 month"));
        return view('admin.processo_folha.new.index', compact('empresa', 'competencia', 'competenciaFormatada', 'socios', 'funcionarios'));
    }

    public function store(Request $request){
        $this->validate($request, ProcessoFolhaValidation::getRules(), [], ProcessoFolhaValidation::getNiceNames());
        if (SendProcessoFolha::handle($request)) {
            return redirect()->route('listProcessoFolhaToAdmin')->with('successAlert', 'Documentos enviados com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function index()
    {
        $empresasPendentes = Empresa::where('status', 'aprovado')
            ->whereHas('socios', function($q){
                $q->where('pro_labore','>',0);
            })
            ->OrWhereHas('funcionarios', function($q){
                $q->where('status','ativo');
            })
            ->whereDoesntHave('processosFolha', function($q){
                $q->whereMonth('created_at', '=', date('m'));
            })
            ->orderBy('nome_fantasia', 'asc')
            ->get();
        $historicoFolha = ProcessoFolha::orderBy('created_at', 'desc')->get();
        return view('admin.processo_folha.index', compact('empresasPendentes', 'historicoFolha'));
    }

    public function validateArquivo(Request $request)
    {
        $rules = ['arquivo' => 'max:10240|required|file|mimes:pdf'];
        $niceNames = ['arquivo' => 'Guia'];
        $this->validate($request, $rules, [], $niceNames);
    }

    public function validateProcesso(Request $request){
        $this->validate($request, ProcessoFolhaValidation::getRules(), [], ProcessoFolhaValidation::getNiceNames());
    }

    public function view($id)
    {
        $processo = ProcessoFolha::findOrFail($id);
        return view('admin.processo_folha.view.index', compact('processo'));
    }

}
