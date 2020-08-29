    <div class="alert alert-info" style="display:block">
        <p>Precisamos de todos os dados abaixo preenchidos corretamente para que possamos obter o alvará junto com a
            prefeitura.</p>
    </div>
<div class="clearfix"></div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="cep">CEP *</label>
        <input type="text" class="form-control cep-mask" value="" name="cep" data-toggle="tooltip"
               data-placement="top"
               title="Informe o CEP do endereço da sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="id_uf">Estado *</label>
        <select class="form-control" name="id_uf" data-toggle="tooltip"
                data-placement="top"
                title="Selecione o estado em que está localizado o endereço da sua empresa">
            <option value="">Selecione uma opção</option>
            @foreach($ufs as $uf)
                <option value="{{$uf->id}}" data-sigla="{{$uf->sigla}}">{{$uf->nome}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="cidade">Cidade *</label>
        <input type="text" class="form-control" value="" name="cidade" data-toggle="tooltip"
               data-placement="top"
               title="Informe a cidade onde estará localizada a sua empresa"
               placeholder="Informe a cidade onde estará localizada a sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="bairro">Bairro *</label>
        <input type="text" class="form-control" value="" name="bairro" data-toggle="tooltip"
               data-placement="top"
               title="Informe o bairro onde estará localizada a sua empresa"
               placeholder="Informe o bairro onde estará localizada a sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="endereco">Endereço *</label>
        <input type="text" class="form-control" value="" name="endereco" data-toggle="tooltip"
               data-placement="top"
               title="Informe o endereço onde estará localizada a sua empresa"
               placeholder="Informe o endereço onde estará localizada a sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="numero">Número *</label>
        <input type="text" class="form-control" value="" name="numero" data-toggle="tooltip"
               data-placement="top"
               title="Informe o número do endereço onde estará localizada a sua empresa"
               placeholder="Informe o número do endereço onde estará localizada a sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" value="" name="complemento" data-toggle="tooltip"
               data-placement="top"
               title="Informe o complemento do endereço onde estará localizada a sua empresa"
               placeholder="Informe o complemento do endereço onde estará localizada a sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="inscricao_iptu">Inscrição IPTU *</label>
        <input type="text" class="form-control" value="" name="iptu" data-toggle="tooltip"
               data-placement="top"
               title="Informe o IPTU ou Cadastro Mobiliário do imóvel onde estará localizada a sua empresa"
               placeholder="Informe o IPTU ou Cadastro Mobiliário do imóvel onde estará localizada a sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="area_ocupada">Área total ocupada em m² *</label>
        <input type="text" class="form-control" value="" name="area_ocupada" data-toggle="tooltip"
               data-placement="top"
               title="Informe a área total que será ocupada no imóvel onde estará localizada a sua empresa"
               placeholder="Informe a área total que será ocupada no imóvel onde estará localizada a sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="area_total">Área total do imóvel m² *</label>
        <input type="text" class="form-control" value="" name="area_total" data-toggle="tooltip"
               data-placement="top"
               title="Informe a área total do imóvel onde estará localizada a sua empresa"
               placeholder="Informe a área total do imóvel onde estará localizada a sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="cpf_cnpj_proprietario">CPF ou CNPJ do proprietário do imóvel *</label>
        <input type="text" class="form-control" value="" name="cpf_cnpj_proprietario" data-toggle="tooltip"
               data-placement="top"
               title="Informe o CPF ou CNPJ do proprietário do imóvel onde estará localizada a sua empresa"
               placeholder="Informe o CPF ou CNPJ do proprietário do imóvel onde estará localizada a sua empresa"/>
    </div>
</div>
<div class="col-xs-12">
    <hr>
    <div class="btn-block text-right">
        <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar <span class="hidden-xs hidden-sm">- Informações da empresa</span>
        </button>
        <button class="btn btn-primary next">Avançar <span class="hidden-xs hidden-sm">- Sócios</span> <i
                    class="fa fa-angle-right"></i></button>
    </div>
</div>
<div class="clearfix"></div>
<br/>