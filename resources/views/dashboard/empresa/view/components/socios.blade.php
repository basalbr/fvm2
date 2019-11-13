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
<table class="table table-striped table-hover">
    <tbody>
    @foreach($empresa->socios as $socio)
        <tr>
            <th scope="row">Nome</th>
            <td><a href="" class="show-socio"
                   data-id="{{$socio->id}}">{{$socio->nome}}{!! $socio->isPrincipal() ? ' <strong>(Sócio Principal)</strong>' : '' !!}</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div><strong><small>Clique no nome do sócio para ver os detalhes</small></strong></div>
<div class="clearfix"></div>