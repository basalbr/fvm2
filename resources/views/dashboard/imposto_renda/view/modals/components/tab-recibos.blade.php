<div role="tab-modalpanel" class="tab-pane" id="tab-modal-recibos">
        <p class="alert-info alert" style="display: block"><strong>Recibos - Dedutíveis:</strong> Deve ser enviado documento comprobatório do declarante, dos valores recebidos
            em {{$anoAnterior}}</p>
        @include('dashboard.imposto_renda.new.components.select', ['descricao'=>'recibo dedutível', 'referencia'=>'recibo_dedutivel', 'opcoes'=>$irRecibosDedutiveis])
    <div class="clearfix"></div>
</div>