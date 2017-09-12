@extends('admin.layouts.master')
@section('top-title')
    Notícias
@stop
@section('content')
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="active tab-pane animated fadeIn" id="todo">
            @include('admin.noticias.components.todo')
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options">
            <a class="btn btn-primary" href="{{route('newNoticia')}}"><i class="fa fa-newspaper-o"></i> Nova notícia</a>
        </div>
    </div>
    <div class="clearfix"></div>

@stop