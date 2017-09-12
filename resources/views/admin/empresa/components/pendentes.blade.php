@include('admin.empresa.components.pendentes-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Nome Fantasia</th>
        <th>Razão Social</th>
        <th>CNPJ</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($empresasPendentes->count())
        @foreach($empresasPendentes as $empresa)
            <tr>
                <td>{{$empresa->usuario->nome}}</td>
                <td>{{$empresa->nome_fantasia}}</td>
                <td>{{$empresa->razao_social}}</td>
                <td>{{$empresa->cnpj}}</td>
                <td>
                    <a href="{{route('showEmpresaToAdmin', $empresa->id)}}" class="btn btn-primary"><i
                                class="fa fa-search"></i> Ver Detalhes</a>
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