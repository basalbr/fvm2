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
            @if($ordemPagamento->valor > 0)
                <tr>
                    <td>{{$ordemPagamento->getDescricao()}}</td>
                    @if($ordemPagamento->isPending())
                        <td>{{$ordemPagamento->getValorComMultaJurosFormatado()}}<br/><span
                                    style="font-size: 11px"><strong class="text-primary">Valor
                            base:</strong> {{$ordemPagamento->formattedValue()}} // <strong
                                        class="text-danger">Multa:</strong> {{$ordemPagamento->getMultaFormatada()}}
                            // <strong
                                        class="text-danger">Juros:</strong> {{$ordemPagamento->getJurosFormatado()}}</span>
                        </td>
                    @else
                        <td>{{$ordemPagamento->valor_pago > 0 ? $ordemPagamento->getValorPago() : $ordemPagamento->formattedValue()}}</td>
                    @endif
                    <td>{{$ordemPagamento->vencimento->format('d/m/Y')}}</td>
                    <td>{{$ordemPagamento->status}}</td>
                    <td>
                        <a class="btn btn-primary"
                           href="{{route('showOrdemPagamentoToAdmin', [$ordemPagamento->id])}}"
                           title="Visualizar"><i class="fa fa-search"></i></a>
                    </td>
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="5">Nenhuma ordem de pagamento encontrada</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>