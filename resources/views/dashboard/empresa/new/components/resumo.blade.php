<!-- Cálculo de mensalidade -->
@include('dashboard.components.mensalidade.simulate')
<div class="alert alert-info" style="display:block">
    <p><strong>Leia com atenção o contrato abaixo</strong> e se tiver dúvidas <a href="{{route('newChamado')}}">
            clique aqui para abrir um chamado</a>, dessa forma vamos poder te ajudar.</p>
</div>
<div class="col-md-6">
    <a class="btn btn-info" type="button" data-toggle="modal" data-target="#modal-contrato-contabilidade"><i class="fa fa-file-o"></i> Contrato de
        prestação de serviços contábeis
    </a>
    <div class="clearfix"></div>
    <br />
<br />
</div>
<div class="col-md-6 summary">

    <div class="description">Mensalidade: <span class="price" id="mensalidade">R$69,90</span></div>
    <ul class="items">
        <li>Quantidade de funcionários: <span id="qtde-funcionarios">0</span></li>
        <li>Quantidade de documentos fiscais recebidos e emitidos mensalmente: <span
                    id="qtde-documentos-fiscais">0</span></li>
    </ul>

</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar<span class="hidden-xs"> - CNAEs</span></button>
    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> De acordo (Finalizar)
    </button>
</div>