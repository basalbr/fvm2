@include('admin.empresa.components.ativas-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Empresa</th>
        <th>CNPJ</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($empresasAtivas->count())
        @foreach($empresasAtivas as $empresa)
            <tr>
                <td><a href="{{route('showUsuarioToAdmin', $empresa->usuario->id)}}">{{$empresa->usuario->nome}}</a></td>
                <td><a href="{{route('showEmpresaToAdmin', $empresa->id)}}">{{$empresa->nome_fantasia}} ({{$empresa->razao_social}})</a></td>
                <td>{{$empresa->cnpj}}</td>
                <td>
                    <a href="{{route('showEmpresaToAdmin', $empresa->id)}}" class="btn btn-primary"><i
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