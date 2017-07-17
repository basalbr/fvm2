@include('admin.alteracao.components.pendentes-filter')

<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Tipo de alteração</th>
        <th>Empresa</th>
        <th>Usuário</th>
        <th>Status</th>
        <th>Pagamento</th>
        <th>Novas mensagens</th>
        <th>Aberto em</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($alteracoesPendentes->count())
        @foreach($alteracoesPendentes as $alteracao)

            <tr>
                <td>{{$alteracao->tipo->descricao}}</td>
                <td>{{$alteracao->empresa->nome_fantasia}}</td>
                <td>{{$alteracao->usuario->nome}}</td>
                <td>{{$alteracao->status}}</td>
                <td>{{$alteracao->pagamento->status}}</td>
                <td>{{$alteracao->mensagens->where('lida', '=', 0)->where('admin', '=', 0)->count()}}</td>
                <td>{{$alteracao->created_at->format('d/m/Y')}}</td>
                <td>
                    <a class="btn btn-primary"
                       href="{{route('showSolicitacaoAlteracaoToAdmin', [$alteracao->id])}}"
                       title="Visualizar"><i class="fa fa-search"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="8">Nenhuma solicitação de alteração encontrada</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>