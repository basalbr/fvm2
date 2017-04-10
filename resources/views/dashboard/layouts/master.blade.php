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

<div id="top-menu" style="">
    <div id="top-menu-brand"><img src="{{url(public_path('images/logotipo-pequeno.png'))}}"/></div>
    <ul id="top-menu-items">
        <li><a href="{{route('logout')}}"><span class="fa fa-sign-outg"></span> Sair</a></li>
    </ul>
</div>
<div id="left-menu">
    <div class="profile">
        <a href="">
            <div class="profile-pic"><img
                        src="https://images.mic.com/0hg7fwagt8yo80cqfdisukrxucvtzv00yaarqmzaj9aj4krhhpprfaqvjbst6tbz.jpg"/>
            </div>
            <div class="profile-name">Olá {{Auth::user()->getFirstName()}}!</div>
            <div class="profile-settings">Clique para editar seu perfil</div>
        </a>
    </div>
    <ul>
        <li><a href="">Início <i class="fa fa-angle-right"></i></a></li>
        <li>
            <a href="">Empresas <i class="fa fa-angle-down"></i></a>
            <ul>
                <li><a href="">Abrir empresa <i class="fa fa-angle-right"></i></a></li>
                <li><a href="">Migrar empresa <i class="fa fa-angle-right"></i></a></li>
            </ul>
        </li>
        <li><a href="">Funcionários <i class="fa fa-angle-right"></i></a></li>
        <li><a href="">Sócios <i class="fa fa-angle-down"></i></a></li>
        <li><a href="">Impostos <i class="fa fa-angle-down"></i></a></li>
        <li><a href="">Financeiro <i class="fa fa-angle-down"></i></a></li>
        <li><a href="">Pagamentos <i class="fa fa-angle-down"></i></a></li>
    </ul>
</div>
@yield('content')
</body>
</html>
