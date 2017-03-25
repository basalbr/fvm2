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
        <link href="https://fonts.googleapis.com/css?family=Muli:400,700,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{url(public_path('vendor/css/bootstrap.min.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(public_path('vendor/css/font-awesome.min.css'))}}"/>
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
<section id="main-banner" class="section">

    <img src="{{url(public_path('images/banner.jpg'))}}"/>
    <div class="banner-content">
        <div class="banner-text">
            <p class="callout">Sua contabilidade agora ficou digital<br/>Acesse nossos serviços onde você estiver</p>
        </div>
        <div class="banner-buttons">
            <a href="" class="btn btn-lg btn-complete">Acesse agora mesmo</a>
            <a href="" class="btn btn-lg btn-warning">Conheça mais sobre nós</a>
        </div>
    </div>
</section>

<section id="como-funciona" class="section bg-m">
    <div class="container">
        <div class="col-xs-12">
            <h1>Oferecemos serviços de contabilidade através da internet</h1>
        </div>
        <div class="col-sm-6">
            <ul class="how-list">
                <li>
                    <div class="text">
                        <h2><span class="fa fa-circle"></span>Público alvo</h2>
                        <p>
                            Para você que tem uma empresa em Santa Catarina, optante pelo Simples Nacional, fornecemos
                            um
                            método econômico e dinâmico para que você realize sua contabilidade.
                            <br/>
                            Oferecemos também serviço de abertura de empresa em toda Santa Catarina. Basta se cadastrar
                            gratuitamente e criar uma solicitação de abertura de empresa.
                        </p>
                    </div>
                    <span class="fa fa-child fa-4x"></span>
                </li>
                <li>
                    <div class="text">
                        <h2><span class="fa fa-circle"></span>Como funciona</h2>
                        <p>
                            Você realiza o cadastro em nosso sistema, cadastra sua empresa e a partir disso nos envia os
                            documentos necessários para realizarmos as apurações.
                            <br/>
                            Nós lhe entregamos as guias para pagamento e lembramos a data de vencimento.
                            Isso tudo de maneira on-line.
                        </p>
                    </div>
                    <span class="fa fa-question fa-4x"></span>
                </li>
                <li>
                    <div class="text">
                        <h2><span class="fa fa-circle"></span>Quanto custa?</h2>
                        <p>
                            Nossa mensalidade custa a partir de R$19,90 por mês e ainda o primeiro mês é totalmente
                            gratuito.
                            <br/>
                            O cadastro é totalmente gratuito, as cobranças serão feitas somente quando estivermos
                            realizando os serviços de apuração ou abertura de empresa.
                        </p>
                    </div>
                    <span class="fa fa-money fa-4x"></span>
                </li>
            </ul>
        </div>
        <div class="col-sm-6">
            <div class="img-holder" style="display: table; min-height: 100%; padding: 50px">
                <img src="{{asset(public_path('images/como-funciona.png'))}}"/>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
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
