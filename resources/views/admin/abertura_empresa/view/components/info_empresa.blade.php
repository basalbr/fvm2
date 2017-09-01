<div class="col-xs-12">
    <h3>Informações da empresa</h3>
    <hr>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Nome preferencial *</label>
        <div class="form-control">{{$aberturaEmpresa->nome_empresarial1}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Nome alternativo *</label>
        <div class="form-control">{{$aberturaEmpresa->nome_empresarial2}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Natureza jurídica *</label>
        <div class="form-control">{{$aberturaEmpresa->naturezaJuridica->descricao}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Enquadramento da empresa *</label>
        <div class="form-control">{{$aberturaEmpresa->enquadramentoEmpresa->descricao}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Tipo de tributação *</label>
        <div class="form-control">{{$aberturaEmpresa->tipoTributacao->descricao}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Quantidade de funcionários *</label>
        <div class="form-control">{{$aberturaEmpresa->qtde_funcionario}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Quantidade de documentos fiscais recebidos e emitidos mensalmente *</label>
        <div class="form-control">{{$aberturaEmpresa->qtde_documento_fiscal}}</div>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="">Capital social *</label>
        <div class="form-control">{{$aberturaEmpresa->capital_social}}</div>
    </div>
</div>
