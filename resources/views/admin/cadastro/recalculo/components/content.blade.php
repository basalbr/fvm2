<div class="col-xs-12">
    <table class="table table-hovered table-striped">
        <thead>
        <tr>
            <th>Descrição</th>
            <th>Valor</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if($recalculos->count())
            @foreach($recalculos as $recalculo)
                <tr>
                    <td>{{$recalculo->descricao}}</td>
                    <td>R$ {{$recalculo->getValor()}}</td>
                    <td><a class="btn btn-primary" href="{{route('viewTipoRecalculo', $recalculo->id)}}"><i
                                    class="fa fa-search"></i></a></td>
                </tr>

            @endforeach
        @else
            <tr>
                <td colspan="3">Nenhum tipo de recálculo cadastrado</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<div class="clearfix"></div>