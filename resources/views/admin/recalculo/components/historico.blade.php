@include('admin.recalculo.components.historico-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Tipo</th>
        <th>Usuário</th>
        <th>Status</th>
        <th>Pagamento</th>
        <th>Novas mensagens</th>
        <th>Aberto em</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if($recalculosConcluidos->count())
        @foreach($recalculosConcluidos as $recalculo)
            <tr>
                <td>{{$recalculo->tipo->descricao}}</td>
                <td>{{$recalculo->usuario->nome}}</td>
                <td>{{$recalculo->getStatus()}}</td>
                <td>{{$recalculo->pagamento->status}}</td>
                <td>{{$recalculo->qtdeMensagensNaoLidas(true)}}</td>
                <td>{{$recalculo->created_at->format('d/m/Y')}}</td>
                <td>
                    <a class="btn btn-primary"
                       href="{{route('showRecalculoToAdmin', [$recalculo->id])}}"
                       title="Visualizar"><i class="fa fa-search"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">Nenhuma solicitação de recálculo encontrada</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>
{{ $recalculosConcluidos->appends(request()->query())->links() }}
<div class="clearfix"></div>