<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Empresa</th>
        <th>Última mensagem</th>
        <th>Novas mensagens?</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($aberturaEmpresas as $aberturaEmpresa)
        <tr>
            <td>{{$aberturaEmpresa->nome_empresarial1}}</td>
            <td>{{$aberturaEmpresa->mensagens()->latest()->first()->mensagem}}</td>
            <td>{{$aberturaEmpresa->getQtdeMensagensNaoLidas()}}</td>
            <td><a class="btn btn-primary"
                   href="{{route('showAberturaEmpresaToAdmin', [$aberturaEmpresa->id])}}"
                   title="Visualizar"><i class="fa fa-search"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $aberturaEmpresas->links() }}
<div class="clearfix"></div>