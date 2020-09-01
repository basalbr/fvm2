<div class="alert alert-info" style="display:block">
    <p><strong>Preencha corretamente</strong> as informações abaixo para que possamos realizar corretamente o procedimento de migração.</p>
</div>
<div class="clearfix"></div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="nome_fantasia">Nome fantasia *</label>
        <input type="text" class="form-control" name="nome_fantasia" value="" data-toggle="tooltip" data-placement="top"
               title="Informe o nome fantasia da sua empresa" placeholder="Informe o nome fantasia da sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="razao_social">Razão Social *</label>
        <input type="text" class="form-control" value="" name="razao_social" data-toggle="tooltip" data-placement="top"
               title="Informe a razão social da sua empresa" placeholder="Informe a razão social da sua empresa"/>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="cnpj">CNPJ *</label>
        <input type="text" class="form-control cnpj-mask" value="" name="cnpj" data-toggle="tooltip" data-placement="top"
               title="Informe o CNPJ da sua empresa"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="inscricao_estadual">Inscrição Estadual</label>
        <input type="text" class="form-control" value="" name="inscricao_estadual" data-toggle="tooltip" data-placement="top"
               title="Informe a isncrição estadual da sua empresa, caso ela possua" placeholder="Informe a isncrição estadual da sua empresa, caso ela possua"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="inscricao_municipal">Inscrição Municipal</label>
        <input type="text" class="form-control" value="" name="inscricao_municipal" data-toggle="tooltip" data-placement="top"
               title="Informe a inscrição municipal/cadastro municipal da sua empresa, caso ela possua" placeholder="Informe a inscrição municipal/cadastro municipal da sua empresa, caso ela possua"/>
    </div>
</div>
<div class="clearfix"></div>

<div class="col-sm-4">
    <div class="form-group">
        <label for="id_natureza_juridica">Natureza Jurídica *</label>
        <select class="form-control" name="id_natureza_juridica" data-toggle="tooltip" data-placement="top"
                title="Selecione a Natureza Jurídica da sua empresa">
            <option value="">Selecione uma opção</option>
            @foreach($naturezasJuridicas as $naturezaJuridica)
                <option value="{{$naturezaJuridica->id}}">{{$naturezaJuridica->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="id_enquadramento_empresa">Enquadramento da empresa *</label>
        <select class="form-control" name="id_enquadramento_empresa" data-toggle="tooltip" data-placement="top"
                title="Selecione o enquadramento da sua empresa">
            <option value="">Selecione uma opção</option>
            @foreach($enquadramentos as $enquadramento)
                <option value="{{$enquadramento->id}}">{{$enquadramento->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="id_tipo_tributacao">Tipo de Tributação *</label>
        <select class="form-control" name="id_tipo_tributacao" data-toggle="tooltip" data-placement="top"
                title="Selecione o tipo de tributação da sua empresa">
            <option value="">Selecione uma opção</option>
            @foreach($tiposTributacao as $tipoTributacao)
                <option value="{{$tipoTributacao->id}}">{{$tipoTributacao->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="clearfix"></div>

<div class="col-sm-5">
    <div class="form-group">
        <label for="codigo_acesso_simples_nacional">Código de acesso ao Simples Nacional</label>
        <input type="text" class="form-control" value="" name="codigo_acesso_simples_nacional" data-toggle="tooltip" data-placement="top"
               title="Informe o código de acesso do Simples Nacional, precisamos dele para gerar suas guias de impostos" placeholder="Informe o código de acesso do Simples Nacional, precisamos dele para gerar suas guias de impostos"/>
    </div>
</div>
<div class="col-sm-7">
    <div class="form-group">
        <label for="crc">Número de registro do CRC do contador atual</label>
        <input type="text" class="form-control" value="" name="crc" data-toggle="tooltip" data-placement="top"
               title="Informe o CRC do seu contador atual para que possamos enviar o termo de transferência" placeholder="Informe o CRC do seu contador atual para que possamos enviar o termo de transferência"/>
    </div>
</div>
<div class="clearfix"></div>

<div class="col-sm-4">
    <div class="form-group">
        <label for="qtde_funcionario">Quantidade de funcionários *</label>
        <input type="text" class="form-control number-mask" value="" name="mensalidade[qtde_funcionario]" data-toggle="tooltip" data-placement="top"
               title="Informe a quantidade atual de funcionários da sua empresa" placeholder="Informe a quantidade atual de funcionários da sua empresa"/>
    </div>
</div>
<div class="col-sm-8">
    <div class="form-group">
        <label for="qtde_documento_fiscal">Quantidade de documentos fiscais recebidos e emitidos mensalmente *</label>
        <input type="text" class="form-control number-mask" value="" name="mensalidade[qtde_documento_fiscal]" data-toggle="tooltip" data-placement="top"
               title="Informe a quantidade de documentos fiscais recebidos e emitidos mensalmente, em média" placeholder="Informe a quantidade de documentos fiscais recebidos e emitidos mensalmente, em média"/>
    </div>
</div>
<div class="clearfix"></div>
<hr>
<div class="col-xs-12">
    <div class="btn-block text-right">
        <button class="btn btn-primary next">Avançar <span class="hidden-xs hidden-sm">- Endereço</span> <span
                    class="fa fa-angle-right"></span>
        </button>
    </div>
</div>
<div class="clearfix"></div>
<br/>