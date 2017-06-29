@extends('dashboard.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Pagamentos</h1>
        <p>Aqui você encontra todos os pagamentos em aberto e também seu histórico de pagamento.</p>
        <hr>
    </div>
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Pagamentos pendentes <span class="badge">{{$pagamentosPendentes->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
                Histórico</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Referência</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Aberto em</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($pagamentosPendentes->count())
                    @foreach($pagamentosPendentes as $pagamento)
                        <tr>
                            <td>{{$pagamento->getDescricao()}}</td>
                            <td>{{$pagamento->formattedValue()}}</td>
                            <td>{{$pagamento->status}}</td>
                            <td>{{$pagamento->created_at->format('d/m/Y')}}</td>
                            <td><a class="btn btn-success" href="{{$pagamento->getBotaoPagamento()}}"
                                   title="Visualizar"><i class="fa fa-credit-card"></i> Pagar</a></td>
                        </tr>

                    @endforeach
                @else
                    <tr><td colspan="5">Nenhum pagamento pendente</td></tr>
                @endif
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
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
                            <td>{{$pagamento->getDescricao()}}</td>
                            <td>{{$pagamento->formattedValue()}}</td>
                            <td>{{$pagamento->status}}</td>
                            <td>{{$pagamento->created_at->format('d/m/Y')}}</td>
                            <td>{{$pagamento->updated_at->format('d/m/Y')}}</td>
                        </tr>

                    @endforeach
                @else
                    <tr><td colspan="5">Nenhum pagamento efetuado</td></tr>
                @endif
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop