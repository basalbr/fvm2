@extends('dashboard.layouts.master')
@section('top-title')
    <a href="{{route('listPontosToUser')}}">Registros de Ponto</a> <i class="fa fa-angle-right"></i> <a
            href="{{route('showEmpresaToUser', $ponto->empresa->id)}}">{{$ponto->empresa->nome_fantasia}}</a>
    <i class="fa fa-angle-right"></i> Envio de Pontos
@stop
@section('video-ajuda')
    <li><a id="btn-ajuda" data-placement="bottom" title="Precisa de ajuda? Veja nosso vídeo explicativo sobre essa página!" href="" data-toggle="modal" data-target="#modal-video-ajuda"><span class="fa fa-youtube-play"></span>
            Ajuda</a></li>
@stop
@section('modal-video-ajuda-titulo', 'Como enviar os registros de ponto')
@section('modal-video-ajuda-embed')
    <iframe width="560" height="315" src="https://www.youtube.com/embed/qojyyPl5Znk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
@stop
@section('content')
    @if($ponto->status == 'pendente')
        @include('dashboard.ponto.view.components.pendente')
    @else
        @include('dashboard.ponto.view.components.nao_pendente')
    @endif
    <div class="navigation-space"></div>
    <div class="navigation-options animated slideInUp">
        <a class="btn btn-default" href="{{URL::previous()}}"><i
                    class="fa fa-angle-left"></i>
            Voltar</a>
        @if($ponto->status == 'pendente')
            <button class="btn btn-success" data-toggle="modal" data-target="#modal-confirma"><i
                        class="fa fa-check"></i>
                Enviar informações
            </button>
        @endif
    </div>
@stop
@section('modals')
    @parent
    <div class="modal animated fadeIn" id="modal-confirma" tabindex="-1" role="dialog" style="z-index: 99999">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Confirma o envio das informações?</h3>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        <br/>
                        <p class="message">Declaro que estou enviando as informações de todos os meus funcionários e
                            entendo que caso estejam incorretas será necessário solicitar o recálculo de folha.</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                    <button type="button" id="sendPontos" class="btn btn-success"><i class="fa fa-check"></i> Sim, envie
                        as informações
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.modals.video-ajuda')
@stop