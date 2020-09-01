<!-- Cálculo de mensalidade -->
@include('dashboard.components.mensalidade.simulate')
<div class="alert alert-info" style="display:block">
    <p><strong>Leia com atenção os termos e o contrato dos serviços contábeis abaixo</strong> e se tiver dúvidas <a
                href="{{route('newChamado')}}">
            clique aqui para abrir um chamado</a>, dessa forma vamos poder te ajudar.</p>
    <p><strong>Ao finalizar a solicitação significa que aceitou nossos termos e contrato.</strong></p>
</div>
<div class="col-md-6">
        <a class="btn btn-info" href="#" data-toggle="modal" data-target="#modal-termos-abertura"><i class="fa fa-file-o"></i> Termos/condições de abertura de empresa
        </a>
    <div class="clearfix"></div>
    <br />
        <a class="btn btn-info" type="button" data-toggle="modal" data-target="#modal-contrato-contabilidade"><i class="fa fa-file-o"></i> Contrato de
            prestação de serviços contábeis
        </a>
    <div class="clearfix"></div>
    <br />
</div>
<div class="col-md-6 summary">
    <p>Abaixo está o resumo da sua solicitação de abertura de empresa.</p>

    <div class="description">Taxa de abertura de empresa: <span
                class="price abertura-price">R${{number_format(\App\Models\Config::getAberturaEmpresaPrice(), 2, ',', '.')}}</span>
    </div>
    <div class="clearfix"></div>
    <div class="description">Mensalidade após obter o CNPJ: <span class="price"
                                     .                             id="mensalidade">R${{number_format(\App\Models\Plano::min('valor'), 2, ',', '.')}}</span>
    </div>
    <div class="clearfix"></div>
    <ul class="items">
        <li>Quantidade de funcionários: <span id="qtde-funcionarios">0</span></li>
        <li>Quantidade de documentos fiscais recebidos e emitidos mensalmente: <span
                    id="qtde-documentos-fiscais">0</span></li>
    </ul>

</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar <span class="hidden-xs hidden-sm">- CNAEs</span>
    </button>
    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Finalizar
    </button>
</div>
<div class="clearfix"></div>
<br/>