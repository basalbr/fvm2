@include('dashboard.components.dependentes.add', ['validationUrl'=>route('validateDependente')])
@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('.show-dependente').on('click', function (e) {
                e.preventDefault();
                $('#modal-dependente-' + $(this).data('id')).modal('show');
            });
        });
    </script>
@stop
<div class="col-xs-12">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Tipo</th>
            <th></th>
        </tr>

        </thead>
        <tbody id="list-dependentes">
        @if(count($funcionario->dependentes))
            @foreach($funcionario->dependentes as $dependente)
                <tr>
                    <td>{{$dependente->nome}}</td>
                    <td>{{$dependente->tipo->descricao}}</td>
                    <td>
                        <button class="btn btn-primary show-dependente" data-id="{{$dependente->id}}"><i class="fa fa-search"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" class="none">Nenhum dependente cadastrado</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
