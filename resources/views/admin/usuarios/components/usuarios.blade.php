@include('admin.usuarios.components.usuarios-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Foto</th>
        <th>Usuário</th>
        <th>E-mail</th>
        <th>Telefone</th>
        <th>Cadastrado em</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($usuarios->count())
        @foreach($usuarios as $usuario)
            <tr>
                <td>
                    <img src="{{$usuario->foto ? asset(public_path().'storage/usuarios/'.$usuario->id.'/'.$usuario->foto) : asset(public_path().'images/thumb.jpg')}}"/>
                </td>
                <td>{{$usuario->nome}}</td>
                <td>{{$usuario->email}}</td>
                <td>{{$usuario->telefone}}</td>
                <td>{{$usuario->created_at->format('d/m/Y')}}</td>
                <td>
                    <a href="{{route('showUsuarioToAdmin', $usuario->id)}}" class="btn btn-primary"><i
                                class="fa fa-search"></i></a>
                </td>
            </tr>

        @endforeach
    @else
        <tr>
            <td colspan="7">Nenhuma empresa encontrada</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>
{{ $usuarios->appends(request()->query())->links() }}
<div class="clearfix"></div>