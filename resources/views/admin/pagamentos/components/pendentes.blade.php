@include('admin.pagamentos.components.pendentes-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Tipo</th>
        <th>Referência</th>
        <th>Valor</th>
        <th>Status</th>
        <th>Aberto em</th>
        <th>Vencimento</th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($pagamentosPendentes->count())
        @foreach($pagamentosPendentes as $pagamento)
            <tr>
                <td>{{$pagamento->usuario->nome}}</td>
                <td>{{$pagamento->getDescricao()}}</td>
                <td>{{$pagamento->getParentName()}}</td>
                <td>{{$pagamento->formattedValue()}}</td>
                <td>{{$pagamento->status}}</td>
                <td>{{$pagamento->created_at->format('d/m/Y')}}</td>
                <td>{{$pagamento->vencimento->format('d/m/Y')}}</td>
            </tr>

        @endforeach
    @else
        <tr>
            <td colspan="6">Nenhum pagamento pendente</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>