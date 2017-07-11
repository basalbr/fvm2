
<div class="col-xs-12">
    <br />
    <div class="col-xs-12">
        <div class="form-group">
            <label for="">Nome fantasia</label>
            <div class="form-control">{{$empresa->nome_fantasia}}</div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            <label for="">CNPJ</label>
            <div class="form-control">{{$empresa->cnpj}}</div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            <label for="">Sócio principal</label>
            <div class="form-control">{{$empresa->getSocioPrincipal()->nome}}</div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            <label for="">Status do processo</label>
            <div class="form-control">{{$empresa->status}}</div>
        </div>
    </div>
</div>
