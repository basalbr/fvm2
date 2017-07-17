<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Aberto em</th>
        <th>Tipo</th>
        <th>Status do Pagamento</th>
        <th>Status</th>
        <th>Novas mensagens</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @if($alteracoes->count())
        @foreach($alteracoes as $alteracao)

            <tr>
                <td>{{$alteracao->created_at->format('d/m/Y H:i:s')}}</td>
                <td>{{$alteracao->tipo->descricao}}</td>
                <td>{{$alteracao->status}}</td>
                <td>{{$alteracao->pagamento->status}}</td>
                <td>{{$alteracao->mensagens()->where('lida', 0)->where('from_admin', 0)->count()}}</td>
                <td>
                    <a class="btn btn-primary"
                       href="{{route('showSolicitacaoAlteracaoToAdmin', [$alteracao->id])}}"
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