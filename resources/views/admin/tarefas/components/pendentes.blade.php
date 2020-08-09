<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Criador</th>
        <th>Assunto</th>
        <th>Expectativa de conclusão</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($tarefasPendentes->count())
        @foreach($tarefasPendentes as $tarefa)
            <tr>
                <td><a href="{{route('showUsuarioToAdmin', $tarefa->criador()->id)}}">{{$tarefa->criador()->nome}}</a></td>
                <td>{{$tarefa->assunto}}</td>
                <td>{{$tarefa->expectativa_conclusao_em->format('d/m/Y à\s H:i')}}</td>
                <td>{!! $tarefa->getLabelStatus() !!}</td>
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
{{ $tarefasPendentes->appends(request()->query())->links() }}
<div class="clearfix"></div>