@include('admin.balancete.components.historico-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Exercício</th>
        <th>CNPJ</th>
        <th>Razão Social</th>
        <th>Usuário</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($balancetes->count())
        @foreach($balancetes as $balancete)
            <tr>
                <td>{{$balancete->exercicio->format('m/Y')}}</td>
                <td>{{$balancete->empresa->cnpj}}</td>
                <td>
                    <a href="{{route('showEmpresaToAdmin', $balancete->empresa->id)}}">{{$balancete->empresa->razao_social}}</a>
                </td>
                <td>
                    <a href="{{route('showUsuarioToAdmin', $balancete->empresa->id_usuario)}}">{{$balancete->empresa->usuario->nome}}</a>
                </td>
                <td>
                    <a class="btn btn-primary" href="{{route('showBalanceteToAdmin', $balancete->id)}}"
                       title="Visualizar">
                        <i class="fa fa-search"></i> Visualizar
                    </a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">Nenhum balancete encontrado</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>
{{ $balancetes->appends(request()->query())->links() }}
<div class="clearfix"></div>