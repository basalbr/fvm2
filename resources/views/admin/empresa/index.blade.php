@extends('admin.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Empresas</h1>
        <p>Nesta área você pode solicitar uma migração de empresa de sua contabilidade atual para a WEBContabilidade e
            visualizar suas empresas cadastradas no sistema.</p>
        <hr>
    </div>
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

