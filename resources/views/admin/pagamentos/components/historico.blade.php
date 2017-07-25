@include('admin.pagamentos.components.historico-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Referência</th>
        <th>Valor</th>
        <th>Status</th>
        <th>Aberto em</th>
        <th>Pago em</th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($historicoPagamento->count())
        @foreach($historicoPagamento as $pagamento)
            <tr>
                <td>{{$pagamento->usuario->nome}}</td>
                <td>{{$pagamento->getDescricao()}}</td>
                <td>{{$pagamento->formattedValue()}}</td>
                <td>{{$pagamento->status}}</td>
                <td>{{$pagamento->created_at->format('d/m/Y')}}</td>
                <td>{{$pagamento->updated_at->format('d/m/Y')}}</td>
            </tr>

        @endforeach
    @else
        <tr>
            <td colspan="6">Nenhum pagamento efetuado</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>