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

<header id="nav-menu" class="transparent">
    @include('index.components.menu')
</header>
<section id="main-banner" class="section">
    @include('index.components.banner-principal')
</section>
<section id="como-funciona" class="section">
    @include('index.components.como-funciona')
</section>

<section id="mensalidade" class="section">
    @include('index.components.mensalidade')
</section>

<section id="duvidas" class="section">
    @include('index.components.duvidas')
</section>

<section id="contato" class="section">
    @include('index.components.contato')
</section>

<div id="modal-content">
    @include('index.modals.acessar')
    @include('index.modals.esqueci')
    @include('index.modals.registrar')
</div>
<div class="clearfix"></div>
</body>
</html>
