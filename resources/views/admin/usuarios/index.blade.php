@extends('admin.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Usuários</h1>
        <hr>
    </div>
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.usuarios.components.tabs')
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="active tab-pane animated fadeIn" id="usuarios">
            @include('admin.usuarios.components.usuarios')
        </div>
    </div>


@stop

