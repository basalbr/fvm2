@include('admin.empresa.components.pendentes-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Empresa</th>
        <th>CNPJ</th>
        <th>Data de ativação</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($empresasPendentes->count())
        @foreach($empresasPendentes as $empresa)
            <tr>
                <td><a href="{{route('showUsuarioToAdmin', $empresa->id)}}">{{$empresa->usuario->nome}}</a></td>
                <td><a href="{{route('showEmpresaToAdmin', $empresa->id)}}">{{$empresa->nome_fantasia}} ({{$empresa->razao_social}})</a></td>
                <td>{{$empresa->cnpj}}</td>
                <td>{{$empresa->ativacao_programada ? $empresa->ativacao_programada->format('d/m/Y') : 'Não está programado'}}</td>
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
{{ $empresasPendentes->appends(request()->query())->appends(['tab'=>'pendentes'])->links() }}
<div class="clearfix"></div>