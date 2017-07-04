@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('.show-socio').on('click', function (e) {
                e.preventDefault();
                $('#modal-socio-' + $(this).data('id')).modal('show');
            });
        });
    </script>
@stop

<div class="col-xs-12">
    <h3>Sócios</h3>
    <hr>
</div>
<div class="col-xs-12">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Sócio principal?</th>
            <th>Opções</th>
        </tr>

        </thead>
        <tbody id="list-socios">
        @if(count($aberturaEmpresa->socios))
            @foreach($aberturaEmpresa->socios as $socio)
                <tr>
                    <td>{{$socio->nome}}</td>
                    <td>{{$socio->isPrincipal()}}</td>
                    <td>
                        <button class="btn btn-primary show-socio" data-id="{{$socio->id}}"><i class="fa fa-search"></i>
                            Detalhes
                        </button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" class="none">Nenhum sócio cadastrado</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>


