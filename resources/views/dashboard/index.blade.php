<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bem vindo à WEBContabilidade</title>
    @section('css')
        @include('index.components.css')
    @show
    @section('js')
        @include('index.components.js')
    @show

</head>
<body>
Olá {{Auth::user()->nome}}. <a href="{{route('logout')}}">Clique aqui para sair.</a>
</body>
</html>
