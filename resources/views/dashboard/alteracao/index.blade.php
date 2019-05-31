@extends('dashboard.layouts.master')
@section('top-title')
    Alterações
@stop
@section('content')

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            @if($empresas->count() >0)
                <div class="panel-body">
                    <p><strong>Selecione uma empresa</strong> para prosseguir à página de solicitações de alteração</p>
                    <br />

                    @foreach($empresas as $empresa)
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="panel-primary bg-info">
                                <div class="panel-heading">
                                    {{$empresa->razao_social}}
                                </div>
                                <div class="panel-body">
                                    <div><strong>CNPJ: </strong> {{$empresa->cnpj}}</div>
                                    <div><strong>Sócio Principal: </strong> {{$empresa->getSocioPrincipal()->nome}}</div>
                                    <div><strong>Solicitações: </strong>{{$empresa->alteracoes()->count()}}</div>
                                </div>
                                <div class="panel-footer">
                                    <a href="{{route('listSolicitacoesAlteracaoToUser', $empresa->id)}}"
                                       class="btn btn-primary btn-block">
                                        Escolher <span class="fa fa-angle-right"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                </div>
            @else
                <div class="col-xs-12"><h4><strong>Você não possui nenhuma empresa cadastrada!</strong></h4></div>
                <div class="panel-body">
                    <p>Nesse caso é necessário que solicite a migração da sua empresa para poder fazer alguma
                        alteração.</p>
                    <a href="{{route('newEmpresa')}}" class="btn btn-primary"><span class="fa fa-external-link"></span>
                        Clique para migrar sua empresa</a>
                </div>
            @endif
            <div class="clearfix"></div>
        </div>

    </div>
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
@stop
