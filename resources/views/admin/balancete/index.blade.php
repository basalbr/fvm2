@extends('admin.layouts.master')
@section('top-title')
    Balancete
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.balancete.components.tabs')
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="historico">
            @include('admin.balancete.components.historico')
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a href="{{route('newBalancete')}}" class="btn btn-primary"><i class="fa fa-send"></i> Enviar um balancete</a>
    </div>
@stop