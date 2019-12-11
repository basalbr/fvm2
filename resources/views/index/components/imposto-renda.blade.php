<div class="container" id="imposto-renda-section">
    <img class="background-img" src="{{url(public_path('images/banner-ir.jpg'))}}"/>
    <div class="col-xs-12">
        <h1>Declaração de Imposto de Renda</h1>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-4">
        <div class="card animated fadeInUp">
            <div class="text-center">
                <span class="fa fa-cog fa-destaque fa-4x"></span>
            </div>
            <h2 class="text-center">
                Como funciona?
            </h2>
            <p class="text-center">
                Você envia todos os documentos necessários para a declaração do seu Imposto de Renda em nosso sistema e nós faremos todo o trabalho para enviar sua declaração.
            </p>
            <div class="text-center">
                <a class="btn btn-primary page-scroll" href="#duvidas">Tire suas dúvidas</a>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card animated fadeInUp">
            <div class="text-center">
                <span class="fa fa-paw fa-destaque fa-4x"></span>
            </div>
            <h2 class="text-center">
                Quanto custa?
            </h2>
            <p class="text-center">
                Se você já possui serviços contábeis conosco o valor é de apenas <strong>R${{number_format(App\Models\Config::getImpostoRendaDiscountPrice(), 2, ',', '.')}}</strong>.<br />
                Caso não seja nosso cliente, o valor fica em <strong>R${{number_format(App\Models\Config::getImpostoRendaFullPrice(), 2, ',', '.')}}</strong>.
            </p>
            <div class="text-center">
                <button data-target="#modal-register" data-toggle="modal" class="btn btn-success zoomIn animated">Cadastre-se agora</button>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card animated fadeInUp">
            <div class="text-center">
                <span class="fa fa-send fa-destaque fa-4x"></span>
            </div>
            <h2 class="text-center">
                Que documentos devo enviar?
            </h2>
            <p class="text-center">
                Nosso sistema vai te guiar no processo de envio de documentos e caso você ainda tenha alguma dúvida poderá falar com um de nossos contadores.
            </p>
            <div class="text-center">
                <button data-target="#modal-access" data-toggle="modal" class="btn btn-warning zoomIn animated">Acesse o sistema</button>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
</div>
