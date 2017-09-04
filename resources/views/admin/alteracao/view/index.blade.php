@extends('admin.layouts.master')
@section('top-title')
    <a href="{{route('listSolicitacoesAlteracaoToAdmin')}}">Alterações</a> <i class="fa fa-angle-right"></i> {{$alteracao->tipo->descricao}}
@stop
@section('content')
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
            <div class="clearfix"></div>

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
            @if($alteracao->status == 'Pendente')
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