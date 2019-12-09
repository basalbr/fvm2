@extends('dashboard.layouts.master')
@section('top-title')
    Décimo terceiro
@stop
@section('content')
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="active tab-pane animated fadeIn" id="todo">
            <div class="col-xs-12">
                <p>{{Auth::user()->nome}}, nesse local é onde ficará disponibilizado os documentos relacionados ao décimo terceiro de suas empresas.</p>
            </div>
            @include('dashboard.decimo_terceiro.components.todo')
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
@stop