<!-- Cálculo de mensalidade -->
@include('admin.components.mensalidade.simulate')

<div class="col-xs-12">
    <h3>Mensalidade após migrar empresa para WEBContabilidade</h3>
    <hr>
</div>
<div class="col-xs-6 summary">

    <div class="description">Mensalidade após conclusão do processo: <span class="price" id="mensalidade">R$19,90</span></div>
    <ul class="items">
        <li>Quantidade de funcionários: <span id="qtde-funcionarios">0</span></li>
        <li>Quantidade de sócios que retiram pró-labore: <span id="qtde-pro-labores">0</span></li>
        <li>Quantidade de documentos contábeis emitidos mensalmente: <span id="qtde-documentos-contabeis">0</span></li>
        <li>Quantidade de documentos fiscais recebidos e emitidos mensalmente: <span id="qtde-documentos-fiscais">0</span></li>
    </ul>

</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar - CNAEs</button>
    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Finalizar
    </button>
</div>