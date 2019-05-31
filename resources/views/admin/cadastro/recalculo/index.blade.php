@extends('admin.layouts.master')
@section('top-title')
    Cadastros <i class="fa fa-angle-right"></i> Recálculos
@stop
@section('content')
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="active tab-pane animated fadeIn">
            @include('admin.cadastro.recalculo.components.content')
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options">
            <a class="btn btn-primary" href="{{route('newTipoRecalculo')}}"><i class="fa fa-plus"></i> Novo recálculo</a>
        </div>
    </div>
    <div class="clearfix"></div>

@stop