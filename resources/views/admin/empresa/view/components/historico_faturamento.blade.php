<div class="col-xs-12">
    <p class="alert alert-info" style="display: block"><strong>Informe o faturamento</strong> dos últimos 12 meses.</p>
</div>
<div class="clearfix"></div>
<form method="post" action="{{route('saveHistoricoFaturamento',$empresa->id)}}">
    <input type="hidden" name="tab" value="historico_faturamento"/>
    <div class="col-sm-12">
        <div class="form-group">
            <label>Data de abertura da empresa</label>
            <input type="text" class="form-control date-mask" name="data_abertura"
                   value="{{$empresa->data_abertura ? $empresa->data_abertura->format('d/m/Y') : ''}}"/>
        </div>
    </div>
    <div class="col-xs-12">
        <p class="alert alert-info" style="display: block"><strong>Mercado interno</strong> / Receita no Brasil</p>
    </div>
    @if(($empresa->data_abertura) && $empresa->data_abertura->diffInMonths(\Carbon\Carbon::now()) >= 1)
        @foreach($empresa->getUltimosDozeMeses() as $month)
            <div class="col-sm-4">
                <div class="form-group">
                    <label>{{$month->format('m/Y')}}</label>
                    <input type="text" class="form-control money-mask"
                           name="historico_faturamento_interno[{{$month->format('Y-m-01')}}]"
                           value="{{isset($historico_faturamento_interno[$month->format('Y-m-01')]) ? $historico_faturamento_interno[$month->format('Y-m-01')] : null }}"/>
                </div>
            </div>
        @endforeach
    @endif
    <div class="col-xs-12">
        <p class="alert alert-info" style="display: block"><strong>Mercado externo</strong> / Receita no exterior</p>
    </div>
    @if(($empresa->data_abertura) && $empresa->data_abertura->diffInMonths(\Carbon\Carbon::now()) >= 1)
        @foreach($empresa->getUltimosDozeMeses() as $month)
            <div class="col-sm-4">
                <div class="form-group">
                    <label>{{$month->format('m/Y')}}</label>
                    <input type="text" class="form-control money-mask"
                           name="historico_faturamento_externo[{{$month->format('Y-m-01')}}]"
                           value="{{isset($historico_faturamento_externo[$month->format('Y-m-01')]) ? $historico_faturamento_externo[$month->format('Y-m-01')] : null }}"/>
                </div>
            </div>
        @endforeach
    @endif
    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary">Salvar informações</button>
    </div>
</form>
<div class="clearfix"></div>

