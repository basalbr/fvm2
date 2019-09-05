@extends('admin.layouts.master')
@include('admin.components.annotation-menu', ['model'=>$reuniao])
@section('top-title')
    <a href="{{route('listRecalculosToAdmin')}}">Reuniões</a> <i class="fa fa-angle-right"></i> {{$reuniao->assunto}}
@stop
@section('content')
    @if($reuniao->pagamento->isPending())
        <div class="alert alert-warning" style="display: block;">O pagamento está pendente</div>
        <div class="clearfix"></div>
    @endif
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.reuniao.view.components.tabs')
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            @include('admin.reuniao.view.components.informacoes')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="messages">
            @include('admin.components.chat.box', ['model'=>$reuniao])

        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="anexos">
            @include('admin.reuniao.view.components.docs')
        </div>
        <div class="navigation-space"></div>
        <div class="navigation-options animated slideInUp">
            <a class="btn btn-default" href="{{URL::previous()}}"><i
                        class="fa fa-angle-left"></i>
                Voltar</a>
        </div>
        <div class="clearfix"></div>
    </div>
@stop