<img class="background-img" src="{{url(public_path('images/banner-simular.jpg'))}}"/>
<div class="container">
    <div class="col-xs-12">
        <h1>Contabilidade com mensalidade acessível</h1>

    </div>
    <div class="col-sm-6">
        <form>
            <div class='form-group'>
                <label for="pro_labores">Quantos sócios retiram pró-labore? <span data-trigger="hover"
                                                                                  class="text-info"
                                                                                  title="Pró-labore é o salário dos sócios que constam no contrato social da empresa, e recolhem o INSS mensalmente para a previdência social."
                                                                                  data-toggle="tooltip"
                                                                                  data-placement="top">(o que é isso?)</span></label>
                <input type='text' class='form-control numero-mask2' id='pro_labores'
                       data-mask-placeholder='0'/>
                <div class="clearfix"></div>
            </div>
            <div class='form-group'>
                <label for="funcionarios">Quantos funcionários possui? <span data-trigger="hover" class="text-info"
                                                                             title="Quantidade de funcionários registrados na empresa. Exigido certificado digital A1."
                                                                             data-toggle="tooltip"
                                                                             data-placement="top">(o que é isso?)</span></label>
                <input type='text' class='form-control numero-mask2' id='funcionarios' data-mask-placeholder='0'/>
            </div>
            <div class='form-group'>
                <label for="total_documentos"> Quantos documentos fiscais são emitidos e recebidos por mês? <span
                            data-trigger="hover"
                            class="text-info"
                            title="Documentos fiscais, são as notas fiscais de venda ou prestação de serviço emitidas, e as notas fiscais de aquisição de mercadorias ou serviços."
                            data-toggle="tooltip"
                            data-placement="top">(o que é isso?)</span></label>
                <input type='text' class='form-control numero-mask2' id='total_documentos'
                       data-mask-placeholder='0'/>
            </div>
            <div class='form-group'>
                <label for="total_contabeis"> Quantos documentos contábeis são emitidos por mês? <span
                            data-trigger="hover"
                            class="text-info"
                            title="Neste item estão a movimentação bancária, em que cada transação corresponde a um documento contábil, assim como recibos de aluguel. Cada valor corresponderá a um documento contábil."
                            data-toggle="tooltip"
                            data-placement="top">(o que é isso?)</span></label>
                <input type='text' class='form-control numero-mask2' id='total_contabeis'
                       data-mask-placeholder='0'/>
            </div>
            <div class='form-group'>
                <label for="contabilidade">Quanto você paga hoje por mês para sua contabilidade?</label>
                <input type='text' class='form-control dinheiro-mask2' id='contabilidade' data-mask-placeholder='0'
                       value="499,99"/>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
    <div class="col-sm-6">
        <p>Para saber quanto custará sua mensalidade, basta completar o formulário ao lado.<br/> O valor da
            mensalidade será atualizado
            automaticamente.</p>
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
            <a href="" data-toggle="modal" data-target="#modal-register" class="btn btn-lg btn-success transparent">Gostou? Crie sua conta</a>
            <a href="" class="btn btn-lg btn-warning transparent">Dúvidas? Entre em contato</a>
        </div>
    </div>
</div>