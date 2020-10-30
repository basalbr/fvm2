@extends('dashboard.layouts.master')
@section('top-title')
    Empresas
@stop
@section('video-ajuda')
    <li><a id="btn-ajuda" data-placement="bottom" title="Precisa de ajuda? Veja nosso vídeo explicativo sobre essa página!" href="" data-toggle="modal" data-target="#modal-video-ajuda"><span class="fa fa-youtube-play"></span>
            Ajuda</a></li>
@stop
@section('modal-video-ajuda-titulo', 'Como migrar sua empresa')
@section('modal-video-ajuda-embed')
    <iframe width="560" height="315" src="https://www.youtube.com/embed/LA4EWysLHko" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
@stop
@section('content')
    @if(count($empresas))
        @foreach($empresas as $empresa)
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>{{$empresa->nome_fantasia}} ({{$empresa->razao_social}}
                                )</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div><strong>CNPJ:</strong> {{$empresa->cnpj}}</div>
                        <div><strong>Sócio principal:</strong> {{$empresa->getSocioPrincipal()->nome}}</div>
                        <div><strong>Status:</strong> {{$empresa->status}}</div>
                        <div>
                            <strong>Limite de documentos
                                fiscais:</strong> {{$empresa->getMensalidadeAtual()->qtde_documento_fiscal}}
                        </div>
                        <div>
                            <strong>Limite de
                                funcionários:</strong> {{$empresa->getMensalidadeAtual()->qtde_funcionario}}
                        </div>
                        <div><strong>Mensalidade: </strong>{{$empresa->getMensalidadeAtual()->getValor()}}</div>
                        <div><strong>Novas mensagens:</strong> {{$empresa->getQtdMensagensNaoLidas()}}</div>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-primary" href="{{route('showEmpresaToUser', [$empresa->id])}}"
                           title="Visualizar"><i class="fa fa-search"></i> Visualizar</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <strong>Você não possui nenhuma empresa cadastrada</strong>, <a href="{{route('newEmpresa')}}">clique
                        aqui</a>
                    para solicitar a migração de sua empresa para a WEBContabilidade.
                </div>
            </div>
        </div>
    @endif
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a href="{{route('newEmpresa')}}" class="btn btn-primary"><span class="fa fa-exchange"></span> Solicitar
            migração de empresa</a>
    </div>
@stop
@section('modals')
    @parent
    @include('dashboard.modals.video-ajuda')
@stop