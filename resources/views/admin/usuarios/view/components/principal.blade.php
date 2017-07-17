<div class="col-md-12 text-center">
    <div class="form-group">
        <img src="{{$usuario->foto ? asset(public_path().'storage/usuarios/'.$usuario->id.'/'.$usuario->foto) : asset(public_path().'images/thumb.jpg')}}"/>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="">Nome</label>
        <div class="form-control">{{$usuario->nome}}</div>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="">E-mail</label>
        <div class="form-control">{{$usuario->email}}</div>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="">Telefone</label>
        <div class="form-control">{{$usuario->telefone}}</div>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="">Criado em</label>
        <div class="form-control">{{$usuario->created_at->format('d/m/Y H:i:s')}}</div>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="">Última atualização</label>
        <div class="form-control">{{$usuario->updated_at->format('d/m/Y H:i:s')}}</div>
    </div>
</div>
<div class="clearfix"></div>