<div class="col-sm-3">
    <div class="form-group">
        <label for="cpf">CPF *</label>
        <input type="text" class="form-control cpf-mask" name="cpf" value="{{$funcionario->cpf}}"/>
    </div>
</div>
<div class="col-sm-3">
    <div class="form-group">
        <label for="rg">RG *</label>
        <input type="text" class="form-control" name="rg" value="{{$funcionario->rg}}"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="orgao_expedidor_rg">Órgão expedidor do RG com UF *</label>
        <input type="text" class="form-control" name="orgao_expedidor_rg" value="{{$funcionario->orgao_expedidor_rg}}"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="data_emissao_rg">Data de emissão RG *</label>
        <input type="text" class="form-control date-mask" name="data_emissao_rg" value="{{$funcionario->data_emissao_rg->format('d/m/Y')}}"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="pis">PIS *</label>
        <input type="text" class="form-control pis-mask" value="{{$funcionario->pis}}" name="pis"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="nacionalidade">Data de cadastro PIS</label>
        <input type="text" class="form-control date-mask" value="{{$funcionario->data_cadastro_pis ? $funcionario->data_cadastro_pis->format('d/m/Y') : ''}}" name="data_cadastro_pis"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="ctps">Carteira de trabalho (CTPS) *</label>
        <input type="text" class="form-control" value="{{$funcionario->ctps}}" name="ctps"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="serie_ctps">Série da CTPS *</label>
        <input type="text" class="form-control" value="{{$funcionario->serie_ctps}}" name="serie_ctps"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="id_uf_ctps">UF de emissão CTPS *</label>
        <select class="form-control" name="id_uf_ctps">
            <option value="">Selecione uma opção</option>
            @foreach($ufs as $uf)
                <option {{$funcionario->id_uf_ctps == $uf->id ? 'selected="selected"' : ''}} value="{{$uf->id}}">{{$uf->nome}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="data_emissao_ctps">Data de emissão CTPS *</label>
        <input type="text" class="form-control date-mask" value="{{$funcionario->data_emissao_ctps->format('d/m/Y')}}" name="data_emissao_ctps"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="titulo_eleitoral">Número do título eleitoral</label>
        <input type="text" class="form-control" value="{{$funcionario->titulo_eleitoral}}" name="titulo_eleitoral"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="zona_secao_eleitoral">Zona e seção eleitoral</label>
        <input type="text" class="form-control" value="{{$funcionario->zona_secao_eleitoral}}" name="zona_secao_eleitoral"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="cnh">Número da CNH</label>
        <input type="text" class="form-control" value="{{$funcionario->cnh}}" name="cnh"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="categoria_cnh">Categoria da CNH</label>
        <input type="text" class="form-control" value="{{$funcionario->categoria_cnh}}" name="categoria_cnh"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="vencimento_cnh">Vencimento da CNH</label>
        <input type="text" class="form-control date-mask" value="{{$funcionario->vencimento_cnh}}" name="vencimento_cnh"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="carteira_reservista">Número de reservista</label>
        <input type="text" class="form-control" value="{{$funcionario->carteira_reservista}}" name="carteira_reservista"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="categoria_carteira_reservista">Categoria de reservista</label>
        <input type="text" class="form-control" value="{{$funcionario->categoria_carteira_reservista}}" name="categoria_carteira_reservista"/>
    </div>
</div>
