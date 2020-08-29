<div class="alert alert-info" style="display:block">
    <p><strong>Atenção!</strong></p>
    <p>Existem algumas regras para escolha da razão social que dependem do tipo de Natureza
        Jurídica escolhido:</p>
    <li><strong>Empresário Individual:</strong> O nome da empresa deverá ser o nome completo do sócio ou uma
        variação do nome junto com a atividade principal. Ex: João Santos Neto, João S. Neto, João S. N.
        Engenharia;
    </li>
    <li><strong>EIRELI:</strong> O nome da empresa deverá possuir ligação direta com pelo menos uma das
        atividades econômicas junto com o sufixo EIRELI. Ex: Chocolândia Fabricação de Chocolates EIRELI;
    </li>
    <li><strong>LTDA:</strong> O nome da empresa deverá possuir ligação direta com pelo menos uma das atividades
        econômicas junto com o sufixo LTDA. Ex: Vidrex Produtos de Vidro LTDA.
    </li>
    <p><strong>* Essas restrições não se aplicam ao nome fantasia.</strong></p>
</div>
<div class="clearfix"></div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="nome_preferencial1">Razão Social *</label>
        <input type="text" class="form-control" data-toggle="tooltip" data-placement="top"
               title="Informe a razão social que gostaria para a sua empresa" name="nome_empresarial1" value=""
               placeholder="Informe a razão social que gostaria para a sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="nome_empresarial2">Nome Fantasia *</label>
        <input type="text" class="form-control" value="" name="nome_empresarial2" data-toggle="tooltip"
               data-placement="top" title="Informe o nome fantasia que gostaria para sua empresa"
               placeholder="Informe o nome fantasia que gostaria para sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="id_natureza_juridica">Natureza Jurídica *</label>
        <select class="form-control" name="id_natureza_juridica" data-toggle="tooltip" data-placement="top"
                title="Selecione o tipo jurídico que você gostaria para sua empresa">
            <option value="">Selecione uma opção</option>
            @foreach($naturezasJuridicas as $naturezaJuridica)
                <option value="{{$naturezaJuridica->id}}">{{$naturezaJuridica->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="id_enquadramento_empresa">Enquadramento da empresa *</label>
        <select class="form-control" name="id_enquadramento_empresa" data-toggle="tooltip" data-placement="top"
                title="Selecione o tipo de enquadramento desejado para sua empresa">
            <option value="">Selecione uma opção</option>
            @foreach($enquadramentos as $enquadramento)
                <option value="{{$enquadramento->id}}">{{$enquadramento->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="id_tipo_tributacao">Tipo de Tributação *</label>
        <select class="form-control" name="id_tipo_tributacao" data-toggle="tooltip" data-placement="top"
                title="Escolha o tipo de tributação para a sua empresa">
            <option value="">Selecione uma opção</option>
            @foreach($tiposTributacao as $tipoTributacao)
                <option value="{{$tipoTributacao->id}}">{{$tipoTributacao->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="qtde_funcionario">Quantidade de Funcionários *</label>
        <input type="text" class="form-control number-mask" value="" name="qtde_funcionario" data-toggle="tooltip"
               data-placement="top" title="Informe a quantidade de funcionários que sua empresa possuirá"
               placeholder="Informe a quantidade de funcionários que sua empresa possuirá"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="qtde_documento_fiscal">Quantidade de documentos fiscais recebidos e emitidos mensalmente *</label>
        <input type="text" class="form-control number-mask" value="" name="qtde_documento_fiscal" data-toggle="tooltip"
               data-placement="top"
               title="Informe quantas notas fiscais sua empresa irá emitir e receber por mês em média"
               placeholder="Informe quantas notas fiscais sua empresa irá emitir por mês em média"/>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="capital_social">Capital social *</label>
        <textarea class="form-control" name="capital_social" data-toggle="tooltip" data-placement="top"
                  title="Informe o valor do capital social e de que forma ele será composto. Ex: R$15.000,00 em dinheiro."
                  placeholder="Informe o valor do capital social e de que forma ele será composto. Ex: R$15.000,00 em dinheiro."></textarea>
    </div>
</div>
<div class="clearfix"></div>
<div class="alert alert-info" style="display:block">
    <strong>Selecione os tipos de atividade que sua empresa irá realizar</strong>. Você pode escolher mais de uma e deve
    escolher
    pelo menos uma atividade.
</div>
<div class="clearfix"></div>
<div class="col-sm-6 col-lg-4">
    <div class="form-group no-border">
        <label class="checkbox checkbox-styled radio-success">
            <input name="is_servico" type="checkbox" class="is-servico-checkbox"
                   data-atividade="servico" value="1"><span></span> Serviços
        </label>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-sm-6 col-lg-4">
    <div class="form-group no-border">
        <label class="checkbox checkbox-styled radio-success">
            <input name="is_comercio" type="checkbox" class="is-comercio-checkbox"
                   data-atividade="comercio" value="1"><span></span> Comércio
        </label>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-sm-6 col-lg-4">
    <div class="form-group no-border">
        <label class="checkbox checkbox-styled radio-success">
            <input name="is_industria" type="checkbox" class="is-industria-checkbox"
                   data-atividade="industria" value="1"><span></span> Indústria
        </label>
        <div class="clearfix"></div>
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