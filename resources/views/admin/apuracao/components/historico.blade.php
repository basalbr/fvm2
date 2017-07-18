@include('admin.apuracao.components.historico-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Empresa</th>
        <th>Imposto</th>
        <th>Competência</th>
        <th>Vencimento</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($apuracoesConcluidas->count())
        @foreach($apuracoesConcluidas as $apuracao)
            <tr>
                <td>{{$apuracao->empresa->nome_fantasia}}</td>
                <td>{{$apuracao->imposto->nome}}</td>
                <td>{{$apuracao->competencia->format('m/Y')}}</td>
                <td>{{$apuracao->vencimento->format('d/m/Y')}}</td>
                <td>{{$apuracao->status}}</td>
                <td>
                    <a class="btn btn-primary" href="{{route('showApuracaoToAdmin', $apuracao->id)}}" title="Visualizar">
                        <i class="fa fa-search"></i> Visualizar
                    </a>
                </td>
            </tr>

        @endforeach
    @else
        <tr>
            <td colspan="6">Nenhuma apuração encontrada</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>