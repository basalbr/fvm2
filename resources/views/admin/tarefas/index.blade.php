@extends('admin.layouts.master')
@section('top-title')
    Tarefas
@stop
@section('content')

    <ul class="nav nav-tabs" role="tablist">
        @include('admin.tarefas.components.tabs')
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="{{!request('tab') || request('tab')=='pendentes' ? 'active' : ''}} tab-pane animated fadeIn" id="pendentes">
            @include('admin.tarefas.components.pendentes')
        </div>
        <div role="tabpanel" class="{{request('tab')=='minhas' ? 'active' : ''}} tab-pane animated fadeIn" id="minhas">
            @include('admin.tarefas.components.minhas')
        </div>
{{--        <div role="tabpanel" class="{{request('tab')=='historico' ? 'active' : ''}} tab-pane animated fadeIn" id="historico">--}}
{{--            @include('admin.tarefas.components.concluidas')--}}
{{--        </div>--}}
        <div class="clearfix"></div>
    </div>

    <div class="navigation-options animated slideInUp">
        <a class="btn btn-primary" href="{{route('newTarefa')}}"><i
                    class="fa fa-plus"></i>
            Criar tarefa</a>
    </div>

@stop