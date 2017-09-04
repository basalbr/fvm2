<div class="col-sm-4">
    <div class="form-group">
        <label>Empresa</label>
        <div class="form-control"><a href='{{route('showEmpresaToAdmin', $processo->empresa->id)}}'>{{$processo->empresa->nome_fantasia}}</a></div>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label>Usuário</label>
        <div class="form-control"><a href="{{route('showUsuarioToAdmin', $processo->empresa->usuario->id)}}">{{$processo->empresa->usuario->nome}}</a></div>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label>Status</label>
        <div class="form-control">{{$processo->getStatus()}}</div>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label>Competência</label>
        <div class="form-control">{{$processo->periodo->format('m/Y')}}</div>
    </div>
</div>


