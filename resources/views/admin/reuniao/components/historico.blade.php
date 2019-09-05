@include('admin.reuniao.components.historico-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Data e horário</th>
        <th>Usuário</th>
        <th>Assunto</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if($reunioesRealizadas->count())
        @foreach($reunioesRealizadas as $reuniao)
            <tr>
                <td>{{$reuniao->data->format('d/m/Y')}} {{$reuniao->horario->hora_inicial}} - {{$reuniao->horario->hora_final}} (<strong>{{$reuniao->quantoFalta()}}</strong>)</td>
                <td>{!! $reuniao->assunto !!}</td>
                <td><a href="{{route('showUsuarioToAdmin', $reuniao->id_usuario)}}">{{ $reuniao->usuario->nome }}</a></td>
                <td>{!! $reuniao->getLabelStatus() !!} {!! $reuniao->pagamento->isPending() ? '<span class="label label-warning">Pagamento pendente</span>' : ''!!}</td>
                <td>
                    <a class="btn btn-primary" href="{{route('showReuniaoToAdmin', $reuniao->id)}}"
                       title="Visualizar">
                        <i class="fa fa-search"></i> Visualizar
                    </a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">Nenhuma reunião marcada...ainda
            </td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>