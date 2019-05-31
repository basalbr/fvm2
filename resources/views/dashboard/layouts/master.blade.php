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
    @include('dashboard.modals.esocial')
@show
@if(Auth::user()->empresas->count() > 0)
    <script type="text/javascript">
        $(function () {
            if (!getAlvaraCookie()) {
                $('.alert-alvara').show();
            }

            $('.btn-alvara').on('click', function (e) {
                e.preventDefault();
                setAlvaraCookie();
                $('.alert-alvara').hide();
            })
        });

        function setAlvaraCookie() {
            var expires = "";
            var date = new Date();
            date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
            document.cookie = "alvara=lido" + expires + "; path=/";
        }

        function getAlvaraCookie() {
            var value = "; " + document.cookie;
            var parts = value.split("; alvara=");
            return parts.pop().split(";").shift() ? true : false;
        }
    </script>
    <div class="alert alert-danger alert-alvara"
         style="position: absolute; bottom: 0; left: 0; right: 0; display: hidden; z-index: 1000000">
        <strong>Atenção!</strong> Verifique a validade do seu alvará e a necessidade de renovar ele junto à prefeitura
        da sua cidade, <strong>nós não oferecemos esse serviço.</strong>
        <button class="btn-alvara btn btn-warning pull-right">Ok, entendi</button>
    </div>
@endif
</body>
</html>
