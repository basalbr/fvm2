@extends('admin.layouts.master')
@include('admin.components.annotation-menu', ['model'=>$processo])
@include('admin.components.tarefas.shortcut')
@section('top-title')
    <a href="{{route('listDocumentosContabeisToAdmin')}}">Documentos Contábeis</a> <i
            class="fa fa-angle-right"></i> {{$processo->empresa->razao_social}} ({{$processo->empresa->nome_fantasia}}) - {{$processo->periodo->format('m/Y')}}
@stop

@section('content')
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Informações e documentos enviados</strong></div>
            <div class="panel-body">
                <ul class="nav nav-tabs nav-tabs-mini" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab">Informações</a>
                    </li>
                    <li role="presentation">
                        <a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab">Documentos <span
                                    class="badge">{{$qtdeDocumentos}}</span></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
                        @include('admin.documentos_contabeis.view.components.informacoes')
                    </div>
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="documentos">
                        @include('admin.documentos_contabeis.view.components.documentos')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Mensagens</strong></div>
            <div class="panel-body" id="messages">
                @include('admin.components.chat.box2', ['model'=>$processo])</div>
        </div>
    </div>
    <div class="navigation-space"></div>
    <div class="navigation-options animated slideInUp">
        <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
        @if(in_array($processo->status, ['documentos_enviados', 'novo', 'pendente', 'sem_movimento']))
            <a class="btn btn-success" href="{{route('contabilizarDocumentoContabil', [$processo->id])}}"><i
                        class="fa fa-check"></i> Contabilizar</a>
        @endif
    </div>
@stop