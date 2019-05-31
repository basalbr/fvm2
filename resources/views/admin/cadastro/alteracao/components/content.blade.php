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
        @if($alteracoes->count())
            @foreach($alteracoes as $alteracao)
                <tr>
                    <td>{{$alteracao->descricao}}</td>
                    <td>{{$alteracao->getValor()}}</td>
                    <td><a class="btn btn-primary" href="{{route('viewTipoAlteracao', $alteracao->id)}}"><i
                                    class="fa fa-search"></i></a></td>
                </tr>

            @endforeach
        @else
            <tr>
                <td colspan="3">Nenhuma notícia cadastrada</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<div class="clearfix"></div>