<div class="col-xs-12">
    <h3>Endereço</h3>
    <hr>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="cep">CEP *</label>
        <div class="form-control">{{$aberturaEmpresa->cep}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="id_uf">Estado *</label>
        <div class="form-control">{{$aberturaEmpresa->uf->nome}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="cidade">Cidade *</label>
        <div class="form-control">{{$aberturaEmpresa->cidade}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="bairro">Bairro *</label>
        <div class="form-control">{{$aberturaEmpresa->bairro}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="endereco">Endereço *</label>
        <div class="form-control">{{$aberturaEmpresa->endereco}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="numero">Número *</label>
        <div class="form-control">{{$aberturaEmpresa->numero}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="complemento">Complemento</label>
        <div class="form-control">{{$aberturaEmpresa->complemento}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="inscricao_iptu">Inscrição IPTU *</label>
        <div class="form-control">{{$aberturaEmpresa->iptu}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="area_ocupada">Área total ocupada em m² *</label>
        <div class="form-control">{{$aberturaEmpresa->area_ocupada}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="area_total">Área total do imóvel m² *</label>
        <div class="form-control">{{$aberturaEmpresa->area_total}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="cpf_cnpj_proprietario">CPF ou CNPJ do proprietário do imóvel *</label>
        <div class="form-control">{{$aberturaEmpresa->cpf_cnpj_proprietario}}</div>
    </div>
</div>
