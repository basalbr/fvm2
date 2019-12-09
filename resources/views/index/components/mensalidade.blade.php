<div class="container">
    <div class="col-xs-12">
        <h1 class="hidden-xs">Contabilidade com mensalidade acessível</h1>
        <h1 class="visible-xs">Mensalidade acessível</h1>
    </div>
    <div class="col-sm-6 col-xs-12">
        <form>
            <div class="card">
                <p class="text-primary"><strong>Para calcular o valor da sua mensalidade basta preencher o formulário
                        abaixo com base em informações da sua empresa.</strong></p>
                <div class='form-group'>
                    <label for="funcionarios">Quantidade de funcionários <span data-trigger="hover"
                                                                               class="text-info hidden-xs"
                                                                               title="Quantidade de funcionários registrados na empresa. Exigido certificado digital A1."
                                                                               data-toggle="tooltip"
                                                                               data-placement="top">(o que é isso?)</span></label>
                    <input type='text' class='form-control number-mask' name="qtde_funcionario"
                           data-mask-placeholder='0'/>
                </div>
                <div class='form-group'>
                    <label for="total_documentos"> Documentos fiscais emitidos e recebidos por mês <span
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
                <div class='form-group'>
                    <label for="contabilidade">Qual o regime de tributação da sua empresa?</label>
                    <div class="radio check-primary checkbox-circle">
                        <input type="radio" checked="checked" value="1" name="regime" id="regime_sn">
                        <label for="regime_sn"> Simples Nacional</label>
                    </div>
                    <div class="radio check-primary checkbox-circle">
                        <input type="radio" value="2" name="regime" id="regime_lp">
                        <label for="regime_lp"> Lucro Presumido</label>
                    </div>
                </div>
                <div class='form-group'>
                    <strong>Em seu plano já está incluso a contabilização dos documentos contábeis.</strong>
                </div>
                <div class='form-group'>
                    <strong>Lucro presumido somente para empresas de serviços</strong>
                </div>

                <div class="clearfix"></div>
                <div class="text-center">
                <a href="#contato" class="page-scroll btn btn-warning hidden-xs">Dúvidas? Entre em
                    contato</a>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-6 hidden-xs">
        <div id="mensalidade-box">
            <div class="card">
                <h2 class='text-center'>Sua mensalidade será</h2>
                <div id="valor-mensalidade" class='text-center'>R$ <span>0,00</span></div>
                <h2 class='text-center'>Você <b>economizará</b></h2>
                <div id='valor-economia' class='text-center'>R$ <span>0,00</span></div>
                <div class="by-year">por ano</div>
                <div class="clearfix"></div>
                <div class="text-center">
                <a href="" data-toggle="modal" data-target="#modal-register"
                   class="btn btn-success hidden-xs">Gostou? Crie sua conta</a>
                </div>
            </div>

        </div>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="col-xs-12 text-center">
        <div class="form-group">
            <a href="" data-toggle="modal" data-target="#modal-simulate"
               class="btn btn-lg btn-complete visible-xs transparent">Simular mensalidade</a>
            <a href="" data-toggle="modal" data-target="#modal-register"
               class="btn btn-lg btn-success transparent visible-xs">Crie sua conta</a>
        </div>
    </div>
</div>