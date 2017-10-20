@extends('dashboard.layouts.master')
@section('top-title')
    Início
@stop
@section('content')
    <div class="col-xs-12">
        <div class="panel">
            <div class="panel-body">
                <h3>Conta temporariamente suspensa</h3>
                <p>Olá {{Auth::user()->nome}}, verificamos que você possui pelo menos uma mensalidade vencida há mais de 30 dias e por isso seu acesso ao sistema foi suspenso.</p>
                <p>Para poder utilizar o sistema novamente, pedimos que realize o pagamento das mensalidades em aberto.</p>
                <table class="table table-hovered table-striped">
                    <thead>
                    <tr>
                        <th>Referência</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Aberto em</th>
                        <th>Vencimento</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <div class="clearfix"></div>
                    @if($pagamentos->count())
                        @foreach($pagamentos as $pagamento)
                            <tr>
                                <td>{{$pagamento->getDescricao()}}</td>
                                <td>{{$pagamento->formattedValue()}}</td>
                                <td>{{$pagamento->status}}</td>
                                <td>{{$pagamento->created_at->format('d/m/Y')}}</td>
                                <td>{{$pagamento->vencimento->format('d/m/Y')}}</td>
                                <td><a class="btn btn-success" href="{{$pagamento->getBotaoPagamento()}}"
                                       title="Visualizar"><i class="fa fa-credit-card"></i> Pagar</a></td>
                            </tr>

                        @endforeach
                    @else
                        <tr><td colspan="5">Nenhum pagamento pendente</td></tr>
                    @endif
                    </tbody>
                </table>
                <p>Se tiver alguma dúvida de como proceder, por favor envie um e-mail para contato@webcontabilidade.com</p>
            </div>
        </div>
    </div>

@stop