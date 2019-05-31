<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Nome preferencial</th>
        <th>Funcionários</th>
        <th>Docs. Fiscais</th>
        <th>Pagamento</th>
        <th>Etapa</th>
        <th>Aberto em</th>
        <th>Última atualização</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @if($aberturasEmpresa->count())
        @foreach($aberturasEmpresa as $aberturaEmpresa)

            <tr>
                <td>{{$aberturaEmpresa->nome_empresarial1}}</td>
                <td>{{$aberturaEmpresa->qtde_funcionario}}</td>
                <td>{{$aberturaEmpresa->qtde_documento_fiscal}}</td>
                <td>{{$aberturaEmpresa->getPaymentStatus()}}</td>
                <td>{{$aberturaEmpresa->getNomeEtapa()}}</td>
                <td>{{$aberturaEmpresa->created_at->format('d/m/Y')}}</td>
                <td>{{$aberturaEmpresa->updated_at->format('d/m/Y')}}</td>
                <td>
                    <a class="btn btn-primary"
                       href="{{route('showAberturaEmpresaToAdmin', [$aberturaEmpresa->id])}}"
                       title="Visualizar"><i class="fa fa-search"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="8">Nenhuma abertura de empresa encontrada</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>