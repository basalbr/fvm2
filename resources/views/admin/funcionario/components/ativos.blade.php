@include('admin.funcionario.components.ativos-filter')

<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Empresa</th>
        <th>Nome</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($funcionarios->count())
        @foreach($funcionarios as $funcionario)
            <tr>
                <td>{{$funcionario->empresa->nome_fantasia}} ({{$funcionario->empresa->razao_social}})</td>
                <td>{{$funcionario->nome_completo}}</td>
                <td>{!! $funcionario->getStatus() !!}</td>
                <td>
                    <a class="btn btn-primary" href="{{route('showFuncionarioToAdmin',[$funcionario->empresa->id, $funcionario->id])}}" title="Visualizar">
                        <i class="fa fa-search"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4">Nenhum funcionário ativo</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>