@if($alteracao->pagamento->isPending())
    <div class="col-xs-12">
        <p class="alert alert-danger visible-lg visible-sm visible-xs visible-md animated shake">O pagamento desse
            processo ainda está pendente.</p>
    </div>
@endif
<div class="{{in_array($alteracao->status, ['concluído', 'concluido', 'cancelado']) ? 'col-xs-12' : 'col-md-6'}}">
<div class="col-sm-12">
    <div class="form-group">
        <label>Usuário</label>
        <div class="form-control"><a
                    href="{{route('showUsuarioToAdmin', $alteracao->usuario->id)}}">{{$alteracao->usuario->nome}}</a>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="form-group">
        <label>Empresa</label>
        <div class="form-control"><a
                    href="{{route('showEmpresaToAdmin', $alteracao->empresa->id)}}">{{$alteracao->empresa->razao_social}}
                ({{$alteracao->empresa->nome_fantasia}})</a>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="form-group">
        <label>Status do pagamento</label>
        <div class="form-control">{{$alteracao->pagamento->status}}</div>
    </div>
</div>
@if(count($alteracao->informacoes))
    @foreach($alteracao->informacoes as $informacao)
        @if($informacao->campo->tipo != 'file')
            <div class="col-sm-12">
                <div class="form-group">
                    <label>{{$informacao->campo->nome}}</label>
                    <div class="form-control">{{$informacao->valor}}</div>
                </div>
            </div>
        @endif
        @if($informacao->campo->tipo == 'file')
            <div class="col-sm-12">
                <div class="form-group">
                    <label>{{$informacao->campo->nome}}</label>
                    <div class="form-control"><a download
                                                 href="{{asset(public_path().'storage/alteracao/'. $alteracao->id .'/'. $informacao->valor)}}"
                                                 title="Clique para fazer download do arquivo">Download</a></div>
                </div>
            </div>
        @endif
    @endforeach
@endif
</div>
<div class="{{in_array($alteracao->status, ['concluído', 'concluido', 'cancelado']) ? 'hidden' : 'col-md-6'}}">
    @include('admin.alteracao.view.components.etapas')
</div>
<div class="clearfix"></div>