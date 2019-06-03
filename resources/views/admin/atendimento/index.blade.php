@extends('admin.layouts.master')
@section('top-title')
    <a href="{{route('listAtendimentosToAdmin')}}">Atendimento</a>
@stop
@section('content')

    <ul class="nav nav-tabs" role="tablist">
        @include('admin.atendimento.components.tabs')
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="chamados">
            @include('admin.atendimento.components.chamados')
        </div>

    </div>
    <div class="clearfix"></div>

@stop