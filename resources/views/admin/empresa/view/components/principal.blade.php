    <div class="col-xs-6">
        <div class="form-group">
            <label for="">Usuário</label>
            <div class="form-control"><a
                        href="{{route('showUsuarioToAdmin', $empresa->usuario->id)}}">{{$empresa->usuario->nome}}</a>
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <label for="">Nome fantasia</label>
            <div class="form-control">{{$empresa->nome_fantasia}}</div>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <label for="">Sócio principal</label>
            <div class="form-control"><a href="" class="show-socio"
                                         data-id="{{$empresa->getSocioPrincipal()->id}}">{{$empresa->getSocioPrincipal()->nome}}</a>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="">CNPJ <a target="_blank" href="http://servicos.receita.fazenda.gov.br/Servicos/cnpjreva/Cnpjreva_Solicitacao.asp?cnpj={{$empresa->cnpj}}}"><i class="fa fa-external-link"></i></a></label>
            <div class="form-control">{{$empresa->cnpj}}
                <button class="btn-link btn-xs copy-to-clipboard"><i class="fa fa-clipboard"></i></button></div>
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
            <div class="form-control">Possui {{$empresa->funcionarios()->where('status', 'ativo')->count()}} com limite
                de {{$empresa->getMensalidadeAtual()->qtde_funcionario}}</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="">Mensalidade</label>
            <div class="form-control">{{$empresa->getMensalidadeAtual()->getValor()}}</div>
        </div>
    </div>
