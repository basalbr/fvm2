@extends('admin.layouts.master')
@section('top-title')
    Recálculos
@stop
@section('content')
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.reuniao.components.tabs')
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="{{!request('tab') || request('tab')=='pendentes' ? 'active' : ''}} tab-pane animated fadeIn" id="pendentes">
            @include('admin.reuniao.components.pendentes')
        </div>
        <div role="tabpanel" class="{{request('tab')=='historico' ? 'active' : ''}} tab-pane animated fadeIn" id="historico">
            @include('admin.reuniao.components.historico')
        </div>
        <div class="clearfix"></div>
    </div>

@stop
