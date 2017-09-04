@extends('admin.layouts.master')
@section('top-title')
    Funcionários
@stop
@section('content')
        <ul class="nav nav-tabs" role="tablist">
        @include('admin.funcionario.components.tabs')
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="{{!request('tab') || request('tab')=='ativos' ? 'active' : ''}} tab-pane animated fadeIn" id="ativos">
            @include('admin.funcionario.components.ativos')
        </div>
        <div role="tabpanel" class="{{request('tab')=='pendentes' ? 'active' : ''}} tab-pane animated fadeIn" id="pendentes">
            @include('admin.funcionario.components.pendentes')
        </div>
        <div class="clearfix"></div>
    </div>
@stop