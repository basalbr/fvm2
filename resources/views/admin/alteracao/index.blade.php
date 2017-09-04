@extends('admin.layouts.master')
@section('top-title')
    Alterações
@stop
@section('content')
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.alteracao.components.tabs')
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="{{!request('tab') || request('tab')=='pendentes' ? 'active' : ''}} tab-pane animated fadeIn" id="pendentes">
            @include('admin.alteracao.components.pendentes')
        </div>
        <div role="tabpanel" class="{{request('tab')=='historico' ? 'active' : ''}} tab-pane animated fadeIn" id="historico">
            @include('admin.alteracao.components.historico')
        </div>
        <div class="clearfix"></div>
    </div>

@stop
