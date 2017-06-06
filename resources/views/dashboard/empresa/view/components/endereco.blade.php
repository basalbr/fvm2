<div class="col-xs-12">
    <h3>Endereço</h3>
    <hr>
</div>
<div class="col-xs-3">
    <div class="form-group">
        <label for="cep">CEP</label>
        <div class="form-control">{{$empresa->cep}}</div>
    </div>
</div>
<div class="col-xs-4">
    <div class="form-group">
        <label for="id_uf">Estado</label>
        <div class="form-control">{{$empresa->uf->nome}}</div>
    </div>
</div>
<div class="col-xs-5">
    <div class="form-group">
        <label for="cidade">Cidade</label>
        <div class="form-control">{{$empresa->cidade}}</div>
    </div>
</div>
<div class="col-xs-4">
    <div class="form-group">
        <label for="bairro">Bairro</label>
        <div class="form-control">{{$empresa->bairro}}</div>
    </div>
</div>
<div class="col-xs-5">
    <div class="form-group">
        <label for="endereco">Endereço</label>
        <div class="form-control">{{$empresa->endereco}}</div>
    </div>
</div>
<div class="col-xs-3">
    <div class="form-group">
        <label for="numero">Número</label>
        <div class="form-control">{{$empresa->numero}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="complemento">Complemento</label>
        <div class="form-control">{{$empresa->complemento}}</div>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="inscricao_iptu">Inscrição IPTU</label>
        <div class="form-control">{{$empresa->iptu}}</div>
    </div>
</div>

