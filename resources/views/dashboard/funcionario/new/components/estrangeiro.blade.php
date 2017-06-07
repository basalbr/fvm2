<div class="col-xs-12">
    <h3>Estrangeiro</h3>
    <hr>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="id_condicao_trabalhador_estrangeiro">Condição *</label>
        <select class="form-control" name="id_condicao_trabalhador_estrangeiro">
            <option value="">Selecione uma opção</option>
            @foreach($condicoesEstrangeiro as $condicaoEstrangeiro)
                <option value="{{$condicaoEstrangeiro->id}}">{{$condicaoEstrangeiro->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="data_chegada_estrangeiro">Data de chegada</label>
        <input type="text" class="form-control date-mask" name="data_chegada_estrangeiro" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="numero_processo_mte">Número do processo MTE</label>
        <input type="text" class="form-control" name="numero_processo_mte" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="numero_rne">Número do RNE</label>
        <input type="text" class="form-control" name="numero_rne" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="data_expedicao_rne">Data de expedição do RNE</label>
        <input type="text" class="form-control date-mask" name="data_expedicao_rne" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="data_validade_rne">Data de validade do RNE</label>
        <input type="text" class="form-control date-mask" name="data_validade_rne" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="validade_carteira_trabalho">Data de validade da CTPS</label>
        <input type="text" class="form-control date-mask" name="validade_carteira_trabalho" value=""/>
    </div>
</div>
<div class="clearfix"></div>

<div class="col-xs-6">
    <div class="checkbox check-primary checkbox-circle">
        <input type="checkbox" checked="checked" value="1" name="casado_estrangeiro" id="casado_estrangeiro">
        <label for="casado_estrangeiro"> Casado(a) com brasileiro(a)</label>
    </div>
</div>
<div class="col-xs-6">
    <div class="checkbox check-primary checkbox-circle">
        <input type="checkbox" checked="checked" value="1" name="filho_estrangeiro" id="filho_estrangeiro">
        <label for="filho_estrangeiro"> Filho(s) com brasileiro(a)</label>
    </div>
</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-primary next">Avançar - Deficiências <span class="fa fa-angle-right"></span>
    </button>
</div>