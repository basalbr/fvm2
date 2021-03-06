<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WEBContabilidade</title>
    @section('css')
        @include('admin.components.css')
    @show
    @section('js')
        @include('admin.components.js')
    @show
</head>
<body data-chat-count-url="{{route('chatCountAjax')}}" data-chat-notification-url="{{route('chatNotificationAjax')}}">
@include('admin.components.top-menu')
@include('admin.components.left-menu')
<div id="content">
    <div class="container-fluid">
        @yield('content')
    </div>
</div>
@section('modals')
    @include('admin.modals.alert')
    @include('admin.modals.success')
@show
</body>
</html>
