<div class="col-sm-3">
    <div class="form-group">
        <label for="cep">CEP *</label>
        <input type="text" class="form-control cep-mask" value="{{$funcionario->cep}}" name="cep"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="id_uf">Estado *</label>
        <select class="form-control" name="id_uf">
            <option value="">Selecione uma opção</option>
            @foreach($ufs as $uf)
                <option {{$funcionario->id_uf == $uf->id ? 'selected="selected"' : ''}} data-sigla="{{$uf->sigla}}" value="{{$uf->id}}">{{$uf->nome}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-5">
    <div class="form-group">
        <label for="cidade">Cidade *</label>
        <input type="text" class="form-control" value="{{$funcionario->cidade}}" name="cidade"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="bairro">Bairro *</label>
        <input type="text" class="form-control" value="{{$funcionario->bairro}}" name="bairro"/>
    </div>
</div>
<div class="col-sm-5">
    <div class="form-group">
        <label for="endereco">Endereço *</label>
        <input type="text" class="form-control" value="{{$funcionario->endereco}}" name="endereco"/>
    </div>
</div>
<div class="col-sm-3">
    <div class="form-group">
        <label for="numero">Número *</label>
        <input type="text" class="form-control" value="{{$funcionario->numero}}" name="numero"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" value="{{$funcionario->complemento}}" name="complemento"/>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-6">
    <div class="form-group no-border">
        <label class="checkbox checkbox-styled radio-success">
            <input type="checkbox" value="1" name="residente_exterior" id="residente_exterior" {{$funcionario->residente_exterior ? 'checked="checked"':''}}><span></span> Residente/domiciliado no exterior
        </label>
        <div class="clearfix"></div>
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group no-border">
        <label class="checkbox checkbox-styled radio-success">
            <input type="checkbox" value="1" name="residencia_propria" id="residencia_propria" {{$funcionario->residencia_propria ? 'checked="checked"':''}}><span></span> Residência própria
        </label>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-sm-12">
    <div class="form-group no-border">
        <label class="checkbox checkbox-styled radio-success">
            <input type="checkbox" value="1" name="imovel_fgts" id="imovel_fgts" {{$funcionario->imovel_fgts ? 'checked="checked"':''}}><span></span> Imóvel adquirido com recursos do FGTS
        </label>
        <div class="clearfix"></div>
    </div>
</div>
