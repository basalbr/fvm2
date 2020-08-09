@section('add-task')
    <li>
        @if(($task = \App\Models\Tarefa::where('mensagem', 'like', '%'.url()->current().'%')->first()) && $task->id)
            <a class="btn btn-success animated flipInY" href="{{route('showTarefaToAdmin', $task->id)}}">
                <span class="fa fa-tasks"></span> <i class="fa fa-external-link"></i>
            </a>

        @else
            <a class="btn btn-success animated flipInY" href="{{route('newTarefa').'?url='.url()->current()}}">
                <span class="fa fa-tasks"></span>
            </a>
        @endif
    </li>
@stop