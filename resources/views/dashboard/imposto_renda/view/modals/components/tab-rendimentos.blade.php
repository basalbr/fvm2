<div role="tabpanel" class="tab-pane" id="tab-modal-rendimentos">
    <p class="alert-info alert" style="display: block"><strong>Rendimentos:</strong> Deve ser enviado documento
        comprobatório do declarante, dos
        valores recebidos
        em {{$anoAnterior}}</p>

    @include('dashboard.imposto_renda.new.components.select', ['descricao'=>'rendimento', 'referencia'=>'rendimentos', 'opcoes'=>$irRendimentos])
    <div class="clearfix"></div>

    <p class="alert-info alert" style="display: block"><strong>Rendimentos Isentos e Não Tributáveis:</strong> Deve ser
        enviado documento comprobatório do declarante, dos
        valores recebidos
        em {{$anoAnterior}}</p>

    @include('dashboard.imposto_renda.new.components.select', ['descricao'=>'rendimento isento e/ou não tributável', 'referencia'=>'rendimentos_isentos', 'opcoes'=>$irRendimentosIsentos])
    <div class="clearfix"></div>

    <p class="alert-info alert" style="display: block"><strong>Rendimentos Sujeitos a Tributação Exclusiva:</strong>
        Deve ser enviado documento comprobatório do declarante, dos
        valores recebidos
        em {{$anoAnterior}}</p>
    @include('dashboard.imposto_renda.new.components.select', ['descricao'=>'rendimento sujeito a tributação exclusiva', 'referencia'=>'tributacao_exclusiva', 'opcoes'=>$irTributacoesExclusivas])
    <div class="clearfix"></div>
</div>