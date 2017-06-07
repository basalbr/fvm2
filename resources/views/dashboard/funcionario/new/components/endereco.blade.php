<div class="col-xs-12">
    <h3>Endereço</h3>
    <hr>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="cep">CEP *</label>
        <input type="text" class="form-control cep-mask" value="" name="cep"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="id_uf">Estado *</label>
        <select class="form-control" name="id_uf">
            <option value="">Selecione uma opção</option>
            @foreach($ufs as $uf)
                <option value="{{$uf->id}}">{{$uf->nome}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="cidade">Cidade *</label>
        <input type="text" class="form-control" value="" name="cidade"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="bairro">Bairro *</label>
        <input type="text" class="form-control" value="" name="bairro"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="endereco">Endereço *</label>
        <input type="text" class="form-control" value="" name="endereco"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="numero">Número *</label>
        <input type="text" class="form-control" value="" name="numero"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" value="" name="complemento"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="inscricao_iptu">Inscrição IPTU *</label>
        <input type="text" class="form-control" value="" name="iptu"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="checkbox check-primary checkbox-circle">
        <input type="checkbox" checked="checked" value="1" name="residente_exterior" id="residente_exterior">
        <label for="residente_exterior"> Residente/Domiciliado no Exterior</label>
    </div>
</div><div class="col-xs-6">
    <div class="checkbox check-primary checkbox-circle">
        <input type="checkbox" checked="checked" value="1" name="residencia_propria" id="residencia_propria">
        <label for="residencia_propria"> Residência Própria</label>
    </div>
</div><div class="col-xs-6">
    <div class="checkbox check-primary checkbox-circle">
        <input type="checkbox" checked="checked" value="1" name="imovel_fgts" id="imovel_fgts">
        <label for="imovel_fgts"> Imóvel
            Adquirido com Recursos do FGTS</label>
    </div>
</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar - Informações da empresa</button>
    <button class="btn btn-primary next">Avançar - Sócios <i class="fa fa-angle-right"></i></button>
</div>