@extends('admin.layouts.master')
@include('admin.components.annotation-menu', ['model'=>$alteracao])
@section('top-title')
    <a href="{{route('listSolicitacoesAlteracaoToAdmin')}}">Alterações</a> <i class="fa fa-angle-right"></i> {{$alteracao->getDescricao()}}
@stop
@section('content')
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Informações e documentos enviados</strong></div>
            <div class="panel-body">
                @if($alteracao->pagamento->isPending())
                    <div class="col-xs-12">
                        <p class="alert alert-danger visible-lg visible-sm visible-xs visible-md animated shake">O pagamento desse
                            processo ainda está pendente</p>
                    </div>
                    <div class="clearfix"></div>
                @endif
                <ul class="nav nav-tabs nav-tabs-mini" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab">Informações</a>
                    </li>
                    <li role="presentation">
                        <a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab">Documentos <span
                                    class="badge">{{$qtdeDocumentos}}</span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
                        @include('admin.alteracao.view.components.informacoes')
                    </div>
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="documentos">
                        @include('admin.alteracao.view.components.documentos')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Mensagens</strong></div>
            <div class="panel-body" id="messages">
                @include('admin.components.chat.box2', ['model'=>$apuracao])</div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="navigation-space-tabless"></div>
    <div class="navigation-options animated slideInUp">
        <a class="btn btn-default" href="{{URL::previous()}}"><i
                    class="fa fa-angle-left"></i>
            Voltar</a>
        <button type="button" data-toggle="modal" data-target="#modal-realizar-acao" class="btn btn-primary"><i
                    class="fa fa-cogs"></i> Alterar Status / Enviar Guia
        </button>
    </div>
    <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.alteracao.view.components.tabs')
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            @include('admin.alteracao.view.components.informacoes')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="messages">
            @include('admin.components.chat.box', ['model'=>$alteracao])

        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="anexos">
            @include('admin.alteracao.view.components.docs')
        </div>
        <hr>
        <div class="navigation-space"></div>
        <div class="navigation-options animated slideInUp">
            <a class="btn btn-default" href="{{URL::previous()}}"><i
                        class="fa fa-angle-left"></i>
                Voltar</a>
            @if(!in_array($alteracao->status, ['concluído', 'concluido', 'cancelado']))
                <a class="btn btn-success" href="{{route('finishAlteracao', $idAlteracao)}}"><i
                            class="fa fa-check"></i>
                    Concluir alteração</a>
                <a class="btn btn-danger" href="{{route('cancelAlteracao', $idAlteracao)}}"><i
                            class="fa fa-close"></i>
                    Cancelar alteração</a>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
@stop