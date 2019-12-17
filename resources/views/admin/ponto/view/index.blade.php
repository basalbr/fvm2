@extends('admin.layouts.master')
@include('admin.components.annotation-menu', ['model'=>$ponto])
@section('top-title')
    <a href="{{route('listPontosToAdmin')}}">Registros de Ponto</a> <i class="fa fa-angle-right"></i> <a
            href="{{route('showEmpresaToAdmin', $ponto->empresa->id)}}">{{$ponto->empresa->nome_fantasia}}</a>
@stop
@section('content')
    @if($ponto->isFinished())
        <div class="col-sm-12">
            <div class="alert alert-success" style="display: block">
                <strong>Processo concluído!</strong>
                <a href="{{route('showProcessoFolhaToAdmin', $ponto->getProcesso()->id)}}"> Clique para ver os recibos
                    <i
                            class="fa fa-external-link"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>
    @endif
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Informações</strong></div>
            <div class="panel-body">
                <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
                    @include('admin.ponto.view.components.informacoes')
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Mensagens</strong></div>
            <div class="panel-body" id="messages">
                @include('admin.components.chat.box2', ['model'=>$ponto, 'lock_anexo'=>false])
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options animated slideInUp">
        <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
        @if($ponto->status != 'concluido')
            <a class="btn btn-success" href="{{route('finishPontos', $ponto->id)}}"><i
                        class="fa fa-check"></i>
                Concluir</a>
        @endif
    </div>
@stop
