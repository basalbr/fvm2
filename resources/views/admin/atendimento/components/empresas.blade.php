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
    @foreach($empresas as $empresa)
        <tr>
            <td>{{$empresa->nome_fantasia}}</td>
            <td>{{$empresa->mensagens()->latest()->first()->mensagem}}</td>
            <td>{{$empresa->getQtdeMensagensNaoLidas()}}</td>
            <td><a class="btn btn-primary" href="{{route('showEmpresaToAdmin', [$empresa->id])}}"
                   title="Visualizar"><i class="fa fa-search"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $empresas->links() }}
<div class="clearfix"></div>