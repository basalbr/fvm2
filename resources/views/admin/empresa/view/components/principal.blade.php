<div class="col-xs-12">
    <div class="col-xs-6">
        <div class="form-group">
            <label for="">Usuário</label>
            <div class="form-control"><a href="{{route('showUsuarioToAdmin', $empresa->usuario->id)}}">{{$empresa->usuario->nome}}</a></div>
        </div>
    </div><div class="col-xs-6">
        <div class="form-group">
            <label for="">Nome fantasia</label>
            <div class="form-control">{{$empresa->nome_fantasia}}</div>
        </div>
    </div>
    <div class="col-xs-6">
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
            <label for="">Mensalidade</label>
            <div class="form-control">{{$empresa->getMensalidadeAtual()->getValor()}}</div>
        </div>
    </div>
</div>
