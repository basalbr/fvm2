<div role="tabpanel" class="tab-pane" id="tab-modal-bens">
        <p class="ano_anterior_div alert-info alert" style="display: block"><strong>Bens e Direitos:</strong> Enviar apenas as variações dos bens e direitos adquiridos
            ou extintos em {{$anoAnterior}}.</p>
        <p class="documentos-declaracao alert-info alert" style="display:none;"><strong>Bens e Direitos:</strong> Enviar documento comprobatório dos bens em
            posse, vendidos e adquiridos em {{$anoAnterior}} pelo declarante.</p>
    @include('dashboard.imposto_renda.edit.components.select', ['descricao'=>'declaração de variação de bens e direitos', 'referencia'=>'bens_direitos', 'opcoes'=>$irBensDireitos])
    <div class="clearfix"></div>
</div>