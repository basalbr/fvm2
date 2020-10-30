<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Tipo</th>
        <th>Status</th>
        <th>Solicitado em</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @if($usuario->recalculos->count())
        @foreach($usuario->recalculos()->orderBy('created_at', 'desc')->get() as $recalculo)

            <tr>
                <td>{{$recalculo->tipo->descricao}}</td>
                <td>{{$recalculo->getStatus()}}</td>
                <td>{{$recalculo->created_at->format('d/m/Y')}}</td>
                <td>
                    <a class="btn btn-primary"
                       href="{{route('showRecalculoToAdmin', $recalculo->id)}}"
                       title="Visualizar"><i class="fa fa-search"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4">Nenhum recálculo encontrado</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>