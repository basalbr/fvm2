@extends('admin.layouts.master')
@section('top-title')
    Usuários
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.usuarios.components.tabs')
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="active tab-pane animated fadeIn" id="usuarios">
            @include('admin.usuarios.components.usuarios')
        </div>
    </div>


@stop

