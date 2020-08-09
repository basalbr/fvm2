<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Assunto</th>
        <th>Expectativa de conclusão</th>
        <th>Concluída em</th>
        <th>Status</th>
        <th>Criada em</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($tarefasCriadas->count())
        @foreach($tarefasCriadas as $tarefa)
            <tr>
                <td>{{$tarefa->assunto}}</td>
                <td>{{$tarefa->expectativa_conclusao_em->format('d/m/Y à\s H:i')}}</td>
                <td>{{$tarefa->conclusao_em ? $tarefa->conclusao_em->format('d/m/Y à\s H:i') : ''}}</td>
                <td>{!! $tarefa->getLabelStatus() !!}</td>
                <td>{{$tarefa->created_at->format('d/m/Y à\s H:i')}}</td>
                <td>
                    <a class="btn btn-primary" href="{{route('showTarefaToAdmin', $tarefa->id)}}" title="Visualizar">
                        <i class="fa fa-search"></i> Visualizar
                    </a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">Nenhuma tarefa pendente</td>
        </tr>
    @endif
    </tbody>
</table>
{{ $tarefasCriadas->appends(request()->query())->links() }}
<div class="clearfix"></div>