<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Referência</th>
        <th>Valor</th>
        <th>Vencimento</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @if($ordensPagamento->count())
        @foreach($ordensPagamento as $ordemPagamento)

            <tr>
                <td>{{$ordemPagamento->getDescricao()}}</td>
                <td>{{$ordemPagamento->formattedValue()}}</td>
                <td>{{$ordemPagamento->vencimento->format('d/m/Y')}}</td>
                <td>{{$ordemPagamento->status}}</td>
                <td>
                    <a class="btn btn-primary"
                       href="{{route('showOrdemPagamentoToAdmin', [$ordemPagamento->id])}}"
                       title="Visualizar"><i class="fa fa-search"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">Nenhuma ordem de pagamento encontrada</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>