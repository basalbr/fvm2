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
<div class="alert alert-info" style="display: block">
    <p><strong>Abaixo os sócios cadastrados nesse processo.</strong> Para alterar os dados dos sócios nos envie uma mensagem.</p>
</div>
<table class="table table-hover table-striped">
    <tbody id="list-socios">
    @if(count($aberturaEmpresa->socios))
        @foreach($aberturaEmpresa->socios as $socio)
            <tr>
                <td>{{$socio->nome}}{!! $socio->isPrincipal() ? '<br /><span class="label label-success">Sócio principal</span>' : '' !!}</td>
                <td>
                    <button class="btn btn-primary show-socio" data-id="{{$socio->id}}"><i
                                class="fa fa-search"></i><span class="hidden-xs"> Detalhes</span></button>
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


