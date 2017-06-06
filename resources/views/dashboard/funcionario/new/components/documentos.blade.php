<div class="col-xs-12">
    <h3>Documentos</h3>
    <hr>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="cpf">CPF *</label>
        <input type="text" class="form-control cpf-mask" name="cpf" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="rg">RG *</label>
        <input type="text" class="form-control" name="rg" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="orgao_expedidor_rg">Órgão expedidor do RG com UF *</label>
        <input type="text" class="form-control" name="orgao_expedidor_rg" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="data_emissao_rg">Data de emissão do RG *</label>
        <input type="text" class="form-control date-mask" name="data_emissao_rg" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="pis">PIS *</label>
        <input type="text" class="form-control pis-mask" value="" name="pis"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="nacionalidade">Data de cadastro do PIS *</label>
        <input type="text" class="form-control date-mask" value="" name="data_cadastro_pis"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="ctps">CTPS *</label>
        <input type="text" class="form-control" value="" name="ctps"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="data_emissao_ctps">Data de emissão da CTPS *</label>
        <input type="text" class="form-control date-mask" value="" name="data_emissao_ctps"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="id_uf_ctps">Estado de emissão da CTPS *</label>
        <select class="form-control" name="id_uf_ctps">
            <option value="">Selecione uma opção</option>
            @foreach($ufs as $uf)
                <option value="{{$uf->id}}">{{$uf->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="titulo_eleitor">Número do título eleitoral *</label>
        <input type="text" class="form-control" value="" name="titulo_eleitor"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="zona_secao_eleitoral">Zona e seção eleitoral *</label>
        <input type="text" class="form-control" value="" name="zona_secao_eleitoral"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="numero_carteira_motorista">Número da CNH</label>
        <input type="text" class="form-control" value="" name="numero_carteira_motorista"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="categoria_carteira_motorista">Categoria da CNH</label>
        <input type="text" class="form-control" value="" name="categoria_carteira_motorista"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="vencimento_carteira_motorista">Vencimento da CNH</label>
        <input type="text" class="form-control date-mask" value="" name="vencimento_carteira_motorista"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="numero_carteira_reservista">Número de reservista</label>
        <input type="text" class="form-control date-mask" value="" name="numero_carteira_reservista"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="categoria_carteira_reservista">Categoria de reservista</label>
        <input type="text" class="form-control date-mask" value="" name="categoria_carteira_reservista"/>
    </div>
</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-primary next">Avançar - Estrangeiro <span class="fa fa-angle-right"></span>
    </button>
</div>