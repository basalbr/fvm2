@extends('admin.layouts.master')
@section('top-title')
    Décimo terceiro
@stop
@section('content')
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="active tab-pane animated fadeIn" id="todo">
            <div class="col-xs-12">
                <p>Para enviar documentos relacionados ao décimo terceiro, clique no botão <strong>enviar
                        documentos</strong>.</p>
            </div>
            @include('admin.decimo_terceiro.components.todo')
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options">
            <a class="btn btn-primary" href="{{route('newDecimoTerceiro')}}"><i class="fa fa-send"></i> Enviar
                documentos</a>
        </div>
    </div>
    <div class="clearfix"></div>

@stop