<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Aberto em</th>
        <th>Assunto</th>
        <th>Status</th>
        <th>Novas mensagens</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @if($chamados->count())
        @foreach($chamados as $chamado)

            <tr>
                <td>{{$chamado->created_at->format('d/m/Y H:i:s')}}</td>
                <td>{{$chamado->tipoChamado->descricao}}</td>
                <td>{{$chamado->status}}</td>
                <td>{{$chamado->mensagens()->where('lida', 0)->where('from_admin', 0)->count()}}</td>
                <td>
                    <a class="btn btn-primary"
                       href="{{route('showChamadoToAdmin', [$chamado->id])}}"
                       title="Visualizar"><i class="fa fa-search"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">Nenhum chamado encontrado</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>