<div role="tabpanel" class="tab-pane animated fadeIn" id="tab-dividas">
    <p class="alert-info alert" style="display: block"><strong>Dívidas e Ônus Reais:</strong> Enviar documento
        comprobatório das dívidas correntes, realizadas e findadas no ano
        de {{$anoAnterior}} pelo declarante.</p>
    @include('dashboard.imposto_renda.new.components.select', ['descricao'=>'documento de dívidas e/ou ônus reais', 'referencia'=>'dividas_onus', 'opcoes'=>$irDividasOnus])
    <div class="clearfix"></div>
</div>