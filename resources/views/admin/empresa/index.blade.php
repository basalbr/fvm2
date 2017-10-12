@extends('admin.layouts.master')
@section('top-title')
    Empresas
@stop
@section('content')
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.empresa.components.tabs')
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="{{!request('tab') || request('tab')=='ativas' ? 'active' : ''}} tab-pane animated fadeIn" id="ativas">
            @include('admin.empresa.components.ativas')
        </div>
        <div role="tabpanel" class="{{request('tab')=='pendentes' ? 'active' : ''}} tab-pane animated fadeIn" id="pendentes">
            @include('admin.empresa.components.pendentes')
        </div>
    </div>
@stop

