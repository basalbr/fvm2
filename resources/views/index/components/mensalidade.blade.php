<img class="background-img" src="{{url(public_path('images/banner-simular.jpg'))}}"/>
<div class="container">
    <div class="col-xs-12">
        <h1 class="hidden-xs">Contabilidade com mensalidade acessível</h1>
        <h1 class="visible-xs">Mensalidade acessível</h1>
    </div>
    <div class="col-xs-12 text-center">
        <p>Para saber quanto custará sua mensalidade, basta completar o formulário ao lado.<br/> O valor da
            mensalidade será atualizado
            automaticamente.</p>
    </div>
    <div class="col-sm-6 col-xs-12">
        <form>
            <div class='form-group'>
                <label for="funcionarios">Quantos funcionários possui? <span data-trigger="hover" class="text-info hidden-xs"
                                                                             title="Quantidade de funcionários registrados na empresa. Exigido certificado digital A1."
                                                                             data-toggle="tooltip"
                                                                             data-placement="top">(o que é isso?)</span></label>
                <input type='text' class='form-control number-mask'  name="qtde_funcionario" data-mask-placeholder='0'/>
            </div>
            <div class='form-group'>
                <label for="total_documentos"> Quantos documentos fiscais são emitidos e recebidos por mês? <span
                            data-trigger="hover"
                            class="text-info hidden-xs"
                            title="Documentos fiscais, são as notas fiscais de venda ou prestação de serviço emitidas, e as notas fiscais de aquisição de mercadorias ou serviços."
                            data-toggle="tooltip"
                            data-placement="top">(o que é isso?)</span></label>
                <input type='text' class='form-control number-mask' name="qtde_documento_fiscal"
                       data-mask-placeholder='0'/>
            </div>
            <div class='form-group'>
                <label for="contabilidade">Quanto você paga hoje por mês para sua contabilidade?</label>
                <input type='text' class='form-control money-mask' id='contabilidade' data-mask-placeholder='0'
                       value="499,99"/>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
    <div class="col-sm-6 hidden-xs">

        <div id="mensalidade-box">
            <h2 class='text-center'>Sua mensalidade será</h2>
            <div id="valor-mensalidade" class='text-center'>R$ <span>0,00</span></div>
            <h2 class='text-center'>Você <b>economizará</b></h2>
            <div id='valor-economia' class='text-center'>R$ <span>0,00</span></div>
            <div class="by-year">por ano*</div>
        </div>

    </div>
    <div class="clearfix"></div>
    <br />
    <div class="col-xs-12 text-center">
        <div class="form-group">
            <a href="" data-toggle="modal" data-target="#modal-simulate" class="btn btn-lg btn-complete visible-xs transparent">Simular mensalidade</a>
            <a href="" data-toggle="modal" data-target="#modal-register" class="btn btn-lg btn-success transparent hidden-xs">Gostou? Crie sua conta</a>
            <a href="" data-toggle="modal" data-target="#modal-register" class="btn btn-lg btn-success transparent visible-xs">Crie sua conta</a>
            <a href="#contato" class="page-scroll btn btn-lg btn-warning hidden-xs transparent">Dúvidas? Entre em contato</a>
        </div>
    </div>
</div>