<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>CNPJ</th>
        <th>Nome Fantasia</th>
        <th>Razão Social</th>
        <th>Sócio Principal</th>
        <th>Mensalidade</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @if($empresas->count())
        @foreach($empresas as $empresa)

            <tr>
                <td>{{$empresa->cnpj}}</td>
                <td>{{$empresa->nome_fantasia}}</td>
                <td>{{$empresa->razao_social}}</td>
                <td>{{$empresa->socios()->where('principal', 1)->first()->nome}}</td>
                <td>{{$empresa->status == 'Aprovado' ? $empresa->getMensalidadeAtual()->getValor() : ''}}</td>
                <td>{{$empresa->status}}</td>
                <td>
                    <a class="btn btn-primary"
                       href="{{route('showEmpresaToAdmin', [$empresa->id])}}"
                       title="Visualizar"><i class="fa fa-search"></i></a>
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