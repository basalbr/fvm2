@extends('dashboard.layouts.master')
@section('top-title')
    Abertura de empresa
@stop
@section('content')
    @if(count($aberturaEmpresas))
        @foreach($aberturaEmpresas as $aberturaEmpresa)
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Nome
                                preferencial: {{$aberturaEmpresa->nome_empresarial1}}</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div><strong>Sócio principal:</strong> {{$aberturaEmpresa->getSocioPrincipal()->nome}}</div>
                        <div><strong>Status do processo:</strong> {{$aberturaEmpresa->status}}</div>
                        <div>
                            <strong>Status do pagamento: </strong>{{$aberturaEmpresa->getPaymentStatus()}}</div>
                        <div><strong>Novas mensagens:</strong> {{$aberturaEmpresa->getQtdMensagensNaoLidas()}}</div>
                        <div><strong>Criada em:</strong> {{$aberturaEmpresa->created_at->format('d/m/Y')}}</div>

                    </div>
                    <div class="panel-footer">
                        @if($aberturaEmpresa->ordemPagamento->isPending())
                            <a target="_blank" href="{{$aberturaEmpresa->ordemPagamento->getBotaoPagamento()}}"
                               class="btn btn-success"><i class="fa fa-credit-card"></i>
                                Pagar {{$aberturaEmpresa->ordemPagamento->formattedValue()}}</a>
                        @endif
                        <a class="btn btn-primary" href="{{route('showAberturaEmpresaToUser', [$aberturaEmpresa->id])}}"
                           title="Visualizar"><i class="fa fa-search"></i> Visualizar</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <strong>Você não solicitou nenhuma abertura de empresa</strong>, <a
                            href="{{route('newAberturaEmpresa')}}">clique aqui</a>
                    para solicitar a abertura de sua empresa conosco.
                </div>
            </div>
        </div>
    @endif
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a href="{{route('newAberturaEmpresa')}}" class="btn btn-primary"><span class="fa fa-child"></span> Solicitar
            abertura de empresa</a>
    </div>
@stop

