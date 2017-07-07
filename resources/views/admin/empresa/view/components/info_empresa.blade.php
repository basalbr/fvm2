<div class="col-xs-12">
    <h3>Informações da empresa</h3>
    <hr>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Nome fantasia</label>
        <div class="form-control">{{$empresa->nome_fantasia}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Razão social</label>
        <div class="form-control">{{$empresa->razao_social}}</div>
    </div>
</div>
<div class="col-xs-4">
    <div class="form-group">
        <label for="">CNPJ</label>
        <div class="form-control">{{$empresa->cnpj}}</div>
    </div>
</div>
<div class="col-xs-4">
    <div class="form-group">
        <label for="">Inscrição estadual</label>
        <div class="form-control">{{$empresa->inscricao_estadual}}</div>
    </div>
</div>
<div class="col-xs-4">
    <div class="form-group">
        <label for="">Inscrição municipal</label>
        <div class="form-control">{{$empresa->inscricao_municipal}}</div>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="">Natureza jurídica</label>
        <div class="form-control">{{$empresa->naturezaJuridica->descricao}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Enquadramento da empresa</label>
        <div class="form-control">{{$empresa->enquadramentoEmpresa->descricao}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Tipo de tributação</label>
        <div class="form-control">{{$empresa->tipoTributacao->descricao}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Código de acesso ao Simples Nacional</label>
        <div class="form-control">{{$empresa->codigo_acesso_simples_nacional}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="">Número de registro do CRC do contador atual</label>
        <div class="form-control">{{$empresa->crc}}</div>
    </div>
</div>
<div class="col-xs-5">
    <div class="form-group">
        <label for="">Quantidade de funcionários</label>
        <div class="form-control">{{$empresa->getMensalidadeAtual()->qtde_funcionario}}</div>
    </div>
</div>
<div class="col-xs-7">
    <div class="form-group">
        <label for="">Quantidade de documentos contábeis emitidos mensalmente</label>
        <div class="form-control">{{$empresa->getMensalidadeAtual()->qtde_documento_contabil}}</div>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="">Quantidade de documentos fiscais recebidos e emitidos mensalmente</label>
        <div class="form-control">{{$empresa->getMensalidadeAtual()->qtde_documento_fiscal}}</div>
    </div>
</div>
