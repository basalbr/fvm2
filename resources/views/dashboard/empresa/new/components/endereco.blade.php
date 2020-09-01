<div class="alert alert-info" style="display:block">
    <p><strong>Preencha corretamente</strong> as informações de endereço abaixo para que possamos realizar corretamente o procedimento de migração.</p>
</div>
<div class="col-sm-3">
    <div class="form-group">
        <label for="cep">CEP *</label>
        <input type="text" class="form-control cep-mask" value="" name="cep" data-toggle="tooltip" data-placement="top"
               title="Informe o CEP do endereço da sua empresa" placeholder="Informe o CEP do endereço da sua empresa"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="id_uf">Estado *</label>
        <select class="form-control" name="id_uf" data-toggle="tooltip" data-placement="top"
                title="Selecione o estado em que sua empresa está estabelecida">
            <option value="">Selecione uma opção</option>
            @foreach($ufs as $uf)
                <option data-sigla="{{$uf->sigla}}" value="{{$uf->id}}">{{$uf->nome}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-5">
    <div class="form-group">
        <label for="cidade">Cidade *</label>
        <input type="text" class="form-control" value="" name="cidade" data-toggle="tooltip" data-placement="top"
               title="Informe a cidade em que sua empresa está estabelecida" placeholder="Informe a cidade em que sua empresa está estabelecida"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="bairro">Bairro *</label>
        <input type="text" class="form-control" value="" name="bairro" data-toggle="tooltip" data-placement="top"
               title="Informe o bairro em que sua empresa está estabelecida" placeholder="Informe o bairro em que sua empresa está estabelecida"/>
    </div>
</div>
<div class="col-sm-5">
    <div class="form-group">
        <label for="endereco">Endereço *</label>
        <input type="text" class="form-control" value="" name="endereco" data-toggle="tooltip" data-placement="top"
               title="Informe o endereço da sua empresa" placeholder="Informe o endereço da sua empresa"/>
    </div>
</div>
<div class="col-sm-3">
    <div class="form-group">
        <label for="numero">Número *</label>
        <input type="text" class="form-control" value="" name="numero" data-toggle="tooltip" data-placement="top"
               title="Informe o número do endereço da sua empresa" placeholder="Informe o número do endereço da sua empresa"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" value="" name="complemento" data-toggle="tooltip" data-placement="top"
               title="Informe o complemento do endereço da sua empresa, caso possua" placeholder="Informe o complemento do endereço da sua empresa, caso possua"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="iptu">Inscrição IPTU</label>
        <input type="text" class="form-control" value="" name="iptu" data-toggle="tooltip" data-placement="top"
               title="Informe o IPTU/Cadastro mobiliário do endereço, caso possua" placeholder="Informe o IPTU/Cadastro mobiliário do endereço, caso possua"/>
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