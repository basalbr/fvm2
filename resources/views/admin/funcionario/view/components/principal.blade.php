<div class="col-sm-6">
    <div class="form-group">
        <label>Nome</label>
        <div class="form-control">
            {{ $funcionario->nome_completo }}
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label>Status</label>
        <div class="form-control">
            {!! $funcionario->getStatus() !!}
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label>Empresa (Nome Fantasia)</label>
        <div class="form-control">
            <a href="{{route('showEmpresaToAdmin', $funcionario->empresa->id)}}">{{$funcionario->empresa->nome_fantasia }}</a>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label>Usuário</label>
        <div class="form-control">
            <a href="{{route('showUsuarioToAdmin', $funcionario->empresa->usuario->id)}}">{{$funcionario->empresa->usuario->nome }}</a>
        </div>
    </div>
</div>

