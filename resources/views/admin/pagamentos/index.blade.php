@extends('admin.layouts.master')
@section('top-title')
    Pagamentos
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.pagamentos.components.tabs')
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="{{!request('tab') || request('tab')=='pendentes' ? 'active' : ''}} tab-pane animated fadeIn" id="pendentes">
            @include('admin.pagamentos.components.pendentes')
        </div>
        <div role="tabpanel" class="{{request('tab')=='historico' ? 'active' : ''}} tab-pane animated fadeIn" id="historico">
            @include('admin.pagamentos.components.historico')
        </div>
    </div>
    <div class="clearfix"></div>

@stop