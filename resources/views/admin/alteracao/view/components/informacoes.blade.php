<div class="col-sm-12">
    <div class="list">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Usuário</label>
                <div class="form-control">{{$alteracao->usuario->nome}}</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nome Fantasia</label>
                <div class="form-control"><a
                            href="{{route('showEmpresaToAdmin', $alteracao->empresa->id)}}">{{$alteracao->empresa->nome_fantasia}}</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Valor</label>
                <div class="form-control">{{$alteracao->pagamento->formattedValue()}}</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Status do processo</label>
                <div class="form-control">{{$alteracao->status}}</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Status do pagamento</label>
                <div class="form-control">{{$alteracao->pagamento->status}}</div>
            </div>
        </div>
        @if(count($alteracao->informacoes))
            @foreach($alteracao->informacoes as $informacao)
                @if($informacao->campo->tipo != 'file')
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{$informacao->campo->nome}}</label>
                            <div class="form-control">{{$informacao->valor}}</div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
<div class="clearfix"></div>