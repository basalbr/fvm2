@extends('dashboard.layouts.master')
@section('content')
    <h1>Empresas</h1>
    <hr>
    @foreach($empresas as $empresa)
        <div class="col-lg-6">
            <div class="panel">
                <div class="col-xs-12">
                    <h3 class="title">{{$empresa->nome_fantasia}}</h3>
                    <hr>
                </div>
                <div class="items">
                    <div class="col-xs-12">
                        <i class="fa fa-user item-icon"></i>
                        <div class="item-value">{{$empresa->getSocioPrincipal()->nome}}</div>
                        <div class="item-description">Sócio principal</div>
                    </div>
                    <div class="col-xs-12">
                        <i class="fa fa-cogs item-icon"></i>
                        <div class="item-value">{{$empresa->status}}</div>
                        <div class="item-description">Status do processo</div>
                    </div>
                    <div class="col-xs-12">
                        <i class="fa fa-credit-card item-icon"></i>
                        <div class="item-value">Pagamento {{$empresa->getPaymentStatus()}}</div>
                        <div class="item-description">Status do pagamento</div>
                    </div>
                    <div class="col-xs-12">
                        <i class="fa fa-envelope item-icon"></i>
                        <div class="item-value">Nenhuma nova mensagem</div>
                        <div class="item-link-description"><a href="">Ver mensagens <i
                                        class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr>
                <div class="col-xs-12 options">
                    <a href="" class="btn btn-success"><i class="fa fa-credit-card"></i>
                        Pagar {{$empresa->ordemPagamento()->formattedValue()}}</a>
                    <a href="{{route('showEmpresaToUser', $empresa->id)}}" class="btn btn-primary"><i
                                class="fa fa-search"></i> Ver Detalhes</a>
                    <a href="" class="btn btn-danger"><i class="fa fa-remove"></i> Cancelar</a>
                </div>
                <div class="clearfix"></div>
                <br/>
            </div>
        </div>
    @endforeach
    <div class="col-lg-6">
        <a href="{{route('newEmpresa')}}">
            <div class="panel add-abertura-empresa">
                <div>
                    <i class="fa fa-child big-icon"></i>
                    <p>Solicitar migração de empresa</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
@stop

