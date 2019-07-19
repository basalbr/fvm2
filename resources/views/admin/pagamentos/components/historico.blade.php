@include('admin.pagamentos.components.historico-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Referência</th>
        <th>Valor</th>
        <th>Valor Pago</th>
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
                <td>
                    <a href="{{route('showUsuarioToAdmin', $pagamento->id_usuario)}}">{{$pagamento->usuario ? $pagamento->usuario->nome : $pagamento->id}}</a>
                </td>
                @if($pagamento->referencia == 'mensalidade')
                    <td>
                        <a href="{{route('showEmpresaToAdmin', $pagamento->parent->id_empresa)}}">{{$pagamento->getParentName()}}</a>
                    </td>
                @else
                    <td>{{$pagamento->getParentName()}}</td>
                @endif
                <td>{{$pagamento->formattedValue()}}</td>
                <td>{{$pagamento->valor_pago > 0 ? $pagamento->getValorPago() : $pagamento->formattedValue()}}</td>
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
{{ $historicoPagamento->appends(request()->all())->links() }}
<div class="clearfix"></div>