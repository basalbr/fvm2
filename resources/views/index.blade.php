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
        <script type="text/javascript" src="{{url(public_path('vendor/js/bootstrap.min.js'))}}"></script>
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

    <img class="background-img" src="{{url(public_path('images/banner.jpg'))}}"/>
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

<section id="como-funciona" class="section">
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
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</section>

<section id="mensalidade" class="section">
    <img class="background-img" src="{{url(public_path('images/banner-simular.jpg'))}}"/>
    <div class="container">
        <div class="col-xs-12">
            <h1>Contabilidade com mensalidade acessível</h1>
            <h3>Para saber quanto custará sua mensalidade, basta completar os campos abaixo. O valor será atualizado
                automaticamente.</h3>
        </div>
        <div class="col-sm-6">
            <form>
                <div class='form-group'>
                        <label for="pro_labores">Quantos sócios retiram pró-labore? <span data-trigger="hover" class="text-info"
                                                                        title="Pró-labore é o salário dos sócios que constam no contrato social da empresa, e recolhem o INSS mensalmente para a previdência social."
                                                                        data-toggle="tooltip" data-placement="top">(o que é isso?)</span></label>
                        <input type='text' class='form-control numero-mask2' id='pro_labores'
                               data-mask-placeholder='0'/>
                    <div class="clearfix"></div>
                </div>
                <hr>
                <div class='form-group'>
                    <label for="funcionarios">Quantos funcionários possui? <span data-trigger="hover" class="text-info"
                                                              title="Quantidade de funcionários registrados na empresa. Exigido certificado digital A1."
                                                              data-toggle="tooltip"
                                                              data-placement="top">(o que é isso?)</span></label>
                    <input type='text' class='form-control numero-mask2' id='funcionarios' data-mask-placeholder='0'/>
                </div>
                <hr>
                <div class='form-group'>
                    <label for="total_documentos"> Quantos documentos fiscais são emitidos e recebidos por mês? <span data-trigger="hover"
                                                                                               class="text-info"
                                                                                               title="Documentos fiscais, são as notas fiscais de venda ou prestação de serviço emitidas, e as notas fiscais de aquisição de mercadorias ou serviços."
                                                                                               data-toggle="tooltip"
                                                                                               data-placement="top">(o que é isso?)</span></label>
                    <input type='text' class='form-control numero-mask2' id='total_documentos'
                           data-mask-placeholder='0'/>
                </div>
                <hr>
                <div class='form-group'>
                    <label for="total_contabeis"> Quantos documentos contábeis são emitidos por mês? <span data-trigger="hover"
                                                                                     class="text-info"
                                                                                     title="Neste item estão a movimentação bancária, em que cada transação corresponde a um documento contábil, assim como recibos de aluguel. Cada valor corresponderá a um documento contábil."
                                                                                     data-toggle="tooltip"
                                                                                     data-placement="top">(o que é isso?)</span></label>
                    <input type='text' class='form-control numero-mask2' id='total_contabeis'
                           data-mask-placeholder='0'/>
                </div>
                <hr>
                <div class='form-group'>
                    <label for="contabilidade">Quanto você paga hoje por mês para sua contabilidade?</label>
                    <input type='text' class='form-control dinheiro-mask2' id='contabilidade' data-mask-placeholder='0'
                           value="499,99"/>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
        <div class="col-sm-6">
            <div id="mensalidade-box">
                <h2 class='text-center'>Sua mensalidade será</h2>
                <div id="valor-mensalidade" class='text-center'>R$ <span>0,00</span></div>
                <h2 class='text-center'>Você <b>economizará</b></h2>
                <div id='valor-economia' class='text-center'>R$ <span>0,00</span></div>
                <div class="by-year">por ano*</div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

</section>
<section id="duvidas">

</section>
<section id="noticias">

</section>
<section id="contato">

</section>
</body>
</html>
