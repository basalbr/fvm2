@include('admin.apuracao.components.historico-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Empresa</th>
        <th>Imposto</th>
        <th>Competência</th>
        <th>CNPJ, CPF e Código de Acesso</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($apuracoesConcluidas->count())
        @foreach($apuracoesConcluidas as $apuracao)
            <tr>
                <td><a href="{{route('showEmpresaToAdmin', $apuracao->id_empresa)}}">{{$apuracao->empresa->razao_social}}</a></td>
                <td>{{$apuracao->imposto->nome}}</td>
                <td>{{$apuracao->competencia->format('m/Y')}}</td>
                <td>{{preg_replace('/[^0-9]/','',$apuracao->empresa->cnpj)}}, {{preg_replace('/[^0-9]/','',$apuracao->empresa->getSocioPrincipal()->cpf)}} e {{preg_replace('/[^0-9]/','',$apuracao->empresa->codigo_acesso_simples_nacional)}}</td>
                <td>{{$apuracao->status}} em {{$apuracao->updated_at->format('d/m/Y H:i')}}</td>
                <td>
                    <a class="btn btn-primary" href="{{route('showApuracaoToAdmin', $apuracao->id)}}" title="Visualizar">Visualizar
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
{{ $apuracoesConcluidas->appends(array_merge(request()->query()))->links() }}
<div class="clearfix"></div>