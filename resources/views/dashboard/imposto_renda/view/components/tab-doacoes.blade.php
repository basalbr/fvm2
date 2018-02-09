<div role="tabpanel" class="tab-pane animated fadeIn" id="tab-doacoes">
    <p class="alert-info alert" style="display: block"><strong>Doações Efetuadas:</strong> Enviar documento comprobatório de doações efetuadas pelo
        declarante no ano
        de {{$anoAnterior}}</p>
    @include('dashboard.imposto_renda.new.components.doacao')
    <div class="clearfix"></div>

    <p class="alert-info alert" style="display: block"><strong>Doações Efetuadas:</strong> Enviar documento comprobatório das doações realizadas pelo
        declarante em {{$anoAnterior}}</p>
    @include('dashboard.imposto_renda.new.components.select', ['descricao'=>'doação a partidos políticos', 'referencia'=>'doacoes_partidos_politicos', 'opcoes'=>$irDoacoesPoliticas])
    <div class="clearfix"></div>
</div>