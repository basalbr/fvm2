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
<body data-spy="scroll" data-target="#nav-menu-items" data-offset="200" >
<header id="nav-menu" class="transparent">
    @include('index.components.menu')
</header>
@yield('content')
<section id="contato" class="section">
    @include('index.components.contato')
</section>

<div id="modal-content">
    @include('index.modals.acessar')
    @include('index.modals.esqueci')
    @include('index.modals.registrar')
    @include('index.modals.sucesso')
</div>
</body>
</html>
