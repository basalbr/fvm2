<div class="col-xs-12">
    <h3>Informações da empresa</h3>
    <hr>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="nome_preferencial1">Nome preferencial *</label>
        <input type="text" class="form-control" name="nome_empresarial1" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="nome_empresarial2">Nome alternativo *</label>
        <input type="text" class="form-control" value="" name="nome_empresarial2"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="id_natureza_juridica">Natureza Jurídica *</label>
        <select class="form-control" name="id_natureza_juridica">
            <option value="">Selecione uma opção</option>
            @foreach($naturezasJuridicas as $naturezaJuridica)
                <option value="{{$naturezaJuridica->id}}">{{$naturezaJuridica->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="id_enquadramento_empresa">Enquadramento da empresa *</label>
        <select class="form-control" name="id_enquadramento_empresa">
            <option value="">Selecione uma opção</option>
            @foreach($enquadramentos as $enquadramento)
                <option value="{{$enquadramento->id}}">{{$enquadramento->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="id_tipo_tributacao">Tipo de Tributação *</label>
        <select class="form-control" name="id_tipo_tributacao">
            <option value="">Selecione uma opção</option>
            @foreach($tiposTributacao as $tipoTributacao)
                <option value="{{$tipoTributacao->id}}">{{$tipoTributacao->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="qtde_funcionarios">Quantidade de Funcionários *</label>
        <input type="text" class="form-control number-mask" value="" name="qtde_funcionario"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="qtde_documento_contabil">Quantidade de documentos contábeis emitidos mensalmente *</label>
        <input type="text" class="form-control number-mask" value="" name="qtde_documento_contabil"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="qtde_documento_fiscal">Quantidade de documentos fiscais recebidos e emitidos mensalmente *</label>
        <input type="text" class="form-control number-mask" value="" name="qtde_documento_fiscal"/>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="capital_social">Capital social *</label>
        <textarea class="form-control" name="capital_social"></textarea>
    </div>
</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-primary next">Avançar - Endereço <span class="fa fa-angle-right"></span>
    </button>
</div>