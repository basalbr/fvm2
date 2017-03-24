<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bem vindo à WEBContabilidade</title>
    @section('css')
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,700,700italic,400italic' rel='stylesheet'>
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{url(public_path('vendor/css/bootstrap.min.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(public_path('css/site.css'))}}"/>
    @show
    @section('js')
        <script type="text/javascript" src="{{url(public_path('vendor/js/jquery.js'))}}"></script>
@show

<!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

</head>
<body>
<header id="nav-menu">
    <div id="nav-menu-brand"><img src="{{url(public_path('images/logotipo-pequeno.png'))}}"/></div>
    <ul id="nav-menu-items">
        <li><a href="">Como funciona</a></li>
        <li><a href="">Mensalidade</a></li>
        <li><a href="">Dúvidas</a></li>
        <li><a href="">Notícias</a></li>
        <li><a href="">Contato</a></li>
        <li><a href="">Acessar</a></li>
    </ul>
</header>
<section id="main-banner">
    <img src="{{url(public_path('images/banner.jpg'))}}"/>
    <div id="banner-content">
        <div id="banner-text">
            <p class="callout">Sua contabilidade agora ficou digital<br/>Acesse nossos serviços onde você estiver</p>
        </div>
        <div id="banner-buttons">
            <a href="" class="btn btn-lg btn-complete">Acesse agora mesmo</a>
            <a href="" class="btn btn-lg btn-warning">Conheça mais sobre nós</a>
        </div>
    </div>
</section>
<section id="como-funciona">

</section>
<section id="mensalidade">

</section>
<section id="duvidas">

</section>
<section id="noticias">

</section>
<section id="contato">

</section>
</body>
</html>
