@extends('admin.layouts.master')
@section('top-title')
    <a href="{{route('listChatToAdmin')}}">Chats</a>
@stop
@section('content')
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.chat.components.tabs')
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="chats">
            @include('admin.chat.components.chats')
        </div>
    </div>
    <div class="clearfix"></div>

@stop