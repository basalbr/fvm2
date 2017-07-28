
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
            <label for="">Sócio principal</label>
            <div class="form-control">{{$empresa->getSocioPrincipal()->nome}}</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="">CNPJ</label>
            <div class="form-control">{{$empresa->cnpj}}</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="">Status da Empresa</label>
            <div class="form-control">{{$empresa->status}}</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="">Funcionários</label>
            <div class="form-control">Possui {{$empresa->funcionarios->count()}} com limite de {{$empresa->getMensalidadeAtual()->qtde_funcionario}}</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="">Pró-labores</label>
            <div class="form-control">Possui {{$empresa->getQtdeProLabores()}} com limite de {{$empresa->getMensalidadeAtual()->qtde_pro_labore}}</div>
        </div>
    </div>
</div>
