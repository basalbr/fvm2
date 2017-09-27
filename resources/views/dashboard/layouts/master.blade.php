<!DOCTYPE html>
<html lang="pt-br">
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
        @if(\Illuminate\Support\Facades\App::environment('production'))
            <script type="text/javascript" src="{{url(public_path().'js/ga.js')}}"></script>
        @endif
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
@section('modals')
    @include('dashboard.modals.alert')
    @include('dashboard.modals.success')
@show
</body>
</html>
