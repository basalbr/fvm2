@extends('dashboard.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Empresas</h1>
        <p>Nesta área você pode solicitar uma migração de empresa de sua contabilidade atual para a WEBContabilidade e
            visualizar suas empresas cadastradas no sistema.</p>
        <hr>
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12">
        <div class="list-group">
            <a href="{{route('newEmpresa')}}" class="btn btn-primary"><span class="fa fa-exchange"></span> Clique aqui para migrar uma empresa</a>
        </div>
    </div>
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
                        <div class="item-description">Status da empresa</div>
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
                    <a href="{{route('showEmpresaToUser', $empresa->id)}}" class="btn btn-primary"><i
                                class="fa fa-search"></i> Ver Detalhes</a>
                    {{--<a href="" class="btn btn-danger"><i class="fa fa-remove"></i> Cancelar</a>--}}
                </div>
                <div class="clearfix"></div>
                <br/>
            </div>
        </div>
    @endforeach

@stop

