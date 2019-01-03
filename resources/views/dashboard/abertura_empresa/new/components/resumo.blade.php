<!-- Cálculo de mensalidade -->
@include('dashboard.components.mensalidade.simulate')

<div class="col-xs-12">
    <h3>Termo de compromisso e resumo do seu pedido</h3>
    <hr>
</div>
<div class="col-md-6">
        <p><strong>Importante!</strong> O serviço de abertura de empresa consiste em:</p>
        <ul>
            <li>Solicitação de viabilidade junto à JUCESC;</li>
            <li>Obtenção de CNPJ junto à Receita Federal;</li>
            <li>Solicitação de inscrição municipal e estadual (quando for comércio ou indústria);</li>
            <li>Solicitação do primeiro alvará junto aos bombeiros e prefeitura;</li>
            <li>Enquadramento no Simples Nacional.</li>
        </ul>
        <p>A entrega física de documentos, seja para regularização de alguma solicitação por parte dos referidos órgãos e/ou protocolo físico, <strong>será feito pelo contratante</strong>.</p>
        <p><strong>Neste serviço não está incluso o valor da mensalidade</strong>, que será cobrada desde a data de abertura do CNPJ para envio das declarações após o término desse processo de abertura de empresa.</p>
        <p>Se o contratante perca algum prazo para protocolar algum documento (normalmente 30 dias), será necessário refazer o processo.</p>
        <p><strong>Ao prosseguir significa que você compreende e aceita esse termo de compromisso.</strong></p>
        <p>Caso tenha alguma dúvida, basta <a href="{{route('newChamado')}}">abrir um chamado</a> que ficaremos felizes em ajudar.</p>
</div>
<div class="col-md-6 summary">

    <p>Abaixo está um resumo da sua solicitação de abertura de empresa.</p>

    <div class="description">Taxa de abertura de empresa: <span class="price abertura-price">R${{number_format(\App\Models\Config::getAberturaEmpresaPrice(), 2, ',', '.')}}</span></div>
    <div class="description">Mensalidade após conclusão do processo: <span class="price" id="mensalidade">R${{number_format(\App\Models\Plano::min('valor'), 2, ',', '.')}}</span></div>
    <ul class="items">
        <li>Quantidade de funcionários: <span id="qtde-funcionarios">0</span></li>
        <li>Quantidade de documentos fiscais recebidos e emitidos mensalmente: <span id="qtde-documentos-fiscais">0</span></li>
    </ul>

</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar - CNAEs</button>
    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Finalizar
    </button>
</div>