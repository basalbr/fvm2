<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WEBContabilidade</title>
    @section('css')
        @include('dashboard.components.css')
    @show
    @section('js')
        @include('dashboard.components.js')
    @show
</head>
<body>
@include('dashboard.components.top-menu')
@include('dashboard.components.left-menu')
<div id="content">
    <div class="container-fluid">
        @yield('content')
    </div>
</div>
@yield('modals')
@include('dashboard.modals.alert')
</body>
</html>
