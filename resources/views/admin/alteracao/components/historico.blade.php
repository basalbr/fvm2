@include('admin.alteracao.components.historico-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Tipo de alteração</th>
        <th>Empresa</th>
        <th>Usuário</th>
        <th>Status</th>
        <th>Última atualização</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($alteracoesConcluidas->count())
        @foreach($alteracoesConcluidas as $alteracao)
            <tr>
                <td>{{$alteracao->tipo->descricao}}</td>
                <td>{{$alteracao->empresa->nome_fantasia}}</td>
                <td>{{$alteracao->usuario->nome}}</td>
                <td>{{$alteracao->status}}</td>
                <td>{{$alteracao->updated_at->format('d/m/Y')}}</td>
                <td>
                    <a class="btn btn-primary"
                       href="{{route('showSolicitacaoAlteracaoToAdmin', [$alteracao->id])}}"
                       title="Visualizar"><i class="fa fa-search"></i></a>
                </td>
            </tr>

        @endforeach
    @else
        <tr>
            <td colspan="6">Nenhuma solicitação de alteração encontrada</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>