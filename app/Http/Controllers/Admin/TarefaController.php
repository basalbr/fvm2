<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Noticia;
use App\Models\Tarefa;
use App\Models\TarefaUsuario;
use App\Models\Usuario;
use App\Services\CancelTarefa;
use App\Services\CreateNoticia;
use App\Services\CreateTarefa;
use App\Services\FinishTarefa;
use App\Services\ReopenTarefa;
use App\Services\StartTarefa;
use App\Services\UpdateNoticia;
use App\Validation\NoticiaValidation;
use App\Validation\TarefaValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PagSeguro\Services\PreApproval\Cancel;

class TarefaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $tarefasPendentes = Tarefa::join('tarefa_usuario', 'tarefa.id', 'tarefa_usuario.id_tarefa')
            ->where('tarefa_usuario.id_usuario', \Auth::user()->id)
            ->where('tarefa_usuario.funcao', 'responsavel')
            ->whereNotIn('tarefa.status', ['concluido', 'cancelado'])
            ->orderBy('tarefa.expectativa_conclusao_em', 'asc')
            ->orderBy('tarefa.created_at', 'asc')
            ->select('tarefa.*')
            ->paginate(15);
        $qtdPendentes = Tarefa::join('tarefa_usuario', 'tarefa.id', 'tarefa_usuario.id_tarefa')
            ->where('tarefa_usuario.id_usuario', \Auth::user()->id)
            ->where('tarefa_usuario.funcao', 'responsavel')
            ->whereNotIn('tarefa.status', ['concluido', 'cancelado'])
            ->orderBy('tarefa.expectativa_conclusao_em', 'asc')
            ->orderBy('tarefa.created_at', 'asc')->count();
        $tarefasCriadas = Tarefa::join('tarefa_usuario', 'tarefa.id', 'tarefa_usuario.id_tarefa')
            ->where('tarefa_usuario.id_usuario', \Auth::user()->id)
            ->where('tarefa_usuario.funcao', 'criador')
->orderByRaw("FIELD(tarefa.status , 'pendente', 'em_execucao', 'concluido', 'cancelado') ASC, tarefa.created_at DESC")
            ->select('tarefa.*')
            ->paginate(15);
        $tarefasConcluidas = Tarefa::whereIn('status', ['concluido', 'cancelado'])->orderBy('conclusao_em', 'desc')->orderBy('created_at', 'asc')->paginate(15);
        return view('admin.tarefas.index', compact('tarefasPendentes', 'tarefasCriadas', 'tarefasConcluidas', 'qtdPendentes'));
    }

    public function new()
    {
        $funcionarios = Usuario::where('admin', 1)->whereNotIn('id',[564, 661, 956])->orderBy('nome')->get();
        return view('admin.tarefas.new.index', compact('funcionarios'));
    }

    public function view($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $isCriador = TarefaUsuario::where('id_usuario', \Auth::user()->id)->where('funcao', 'criador')->count() > 0 || in_array(\Auth::user()->id, [1, 57]) ? true : false;
        $isResponsavel = TarefaUsuario::where('id_usuario', \Auth::user()->id)->where('funcao', 'responsavel')->count() > 0 ? true : false;
        return view('admin.tarefas.view.index', compact('tarefa', 'isCriador', 'isResponsavel'));
    }

    public function store(Request $request)
    {
        if (CreateTarefa::handle($request)) {
            return redirect()->route('listTarefasToAdmin')->with('successAlert', 'Tarefa cadastrada');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function update(Request $request, $id)
    {
        if (UpdateNoticia::handle($request, $id)) {
            return redirect()->route('listNoticiasToAdmin')->with('successAlert', 'Notícia editada com sucesso');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function start($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        if (StartTarefa::handle($tarefa)) {
            return redirect()->route('showTarefaToAdmin', $id)->with('successAlert', 'Tarefa iniciada');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function finish($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        if (FinishTarefa::handle($tarefa)) {
            return redirect()->route('showTarefaToAdmin', $id)->with('successAlert', 'Tarefa concluída');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function reopen($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        if (ReopenTarefa::handle($tarefa)) {
            return redirect()->route('showTarefaToAdmin', $id)->with('successAlert', 'Tarefa reaberta');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function cancel($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        if (CancelTarefa::handle($tarefa)) {
            return redirect()->route('showTarefaToAdmin', $id)->with('successAlert', 'Tarefa cancelada');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * @param Request $request
     */
    public function validateTarefa(Request $request)
    {
        $this->validate($request, TarefaValidation::getRules(), [], TarefaValidation::getNiceNames());
    }


}
