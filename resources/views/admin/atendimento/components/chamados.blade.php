<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Assunto</th>
        <th>Status</th>
        <th>Aberto em</th>
        <th>Última mensagem</th>
        <th>Recebida em</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($chamados->count())
        @foreach($chamados as $chamado)
            <tr>
                <td>{{$chamado->usuario->nome}}</td>
                <td>{{$chamado->tipoChamado->descricao}}</td>
                <td>{{$chamado->status}}</td>
                <td>{{$chamado->created_at->format('d/m/Y H:i')}}</td>
                <td>{{$chamado->mensagens()->latest()->first()->mensagem}}</td>
                <td>{{$chamado->mensagens()->latest()->first()->created_at->format('d/m/Y H:i')}}</td>
                <td><a class="btn btn-primary" href="{{route('showChamadoToAdmin', [$chamado->id])}}"
                       title="Visualizar"><i class="fa fa-search"></i></a></td>
            </tr>

        @endforeach
    @else
        <tr>
            <td colspan="7">Nenhum chamado encontrado</td>
        </tr>
    @endif
    </tbody>
</table>