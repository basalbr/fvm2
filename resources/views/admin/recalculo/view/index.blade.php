@extends('admin.layouts.master')
@include('admin.components.annotation-menu', ['model'=>$recalculo])
@section('top-title')
    <a href="{{route('listRecalculosToAdmin')}}">Recálculos</a> <i class="fa fa-angle-right"></i> {{$recalculo->tipo->descricao}}
@stop
@section('content')
    @if($recalculo->pagamento->isPending())
        <div class="alert alert-warning" style="display: block;">O pagamento dessa solicitação
            está com o
            status {{$recalculo->pagamento->status}}
        </div>
        <div class="clearfix"></div>
    @endif
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.recalculo.view.components.tabs')
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            @include('admin.recalculo.view.components.informacoes')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="messages">
            @include('admin.components.chat.box', ['model'=>$recalculo])

        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="anexos">
            @include('admin.recalculo.view.components.docs')
        </div>
        <div class="navigation-space"></div>
        <div class="navigation-options animated slideInUp">
            <a class="btn btn-default" href="{{URL::previous()}}"><i
                        class="fa fa-angle-left"></i>
                Voltar</a>
            @if($recalculo->status == 'Pendente')
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