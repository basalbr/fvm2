@include('admin.apuracao.components.pendentes-filter')

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
    @if($apuracoesPendentes->count())
        @foreach($apuracoesPendentes as $apuracao)
            <tr>
                <td><a href="{{route('showEmpresaToAdmin', $apuracao->id_empresa)}}">{{$apuracao->empresa->razao_social}}</a> {!! strtolower($apuracao->empresa->tipoTributacao->descricao) == 'mei' ? '<span class="label label-warning">MEI</span>' : '' !!}</td>
                <td>{{$apuracao->imposto->nome}}</td>
                <td>{{$apuracao->competencia->format('m/Y')}}</td>
                <td>{{preg_replace('/[^0-9]/','',$apuracao->empresa->cnpj)}}, {{preg_replace('/[^0-9]/','',$apuracao->empresa->getSocioPrincipal()->cpf)}} e {{preg_replace('/[^0-9]/','',$apuracao->empresa->codigo_acesso_simples_nacional)}}</td>
                <td>{!! $apuracao->getLabelStatus() !!} {{$apuracao->updated_at->format('d/m/Y H:i')}}</td>
                <td>
                    <a class="btn btn-primary" href="{{route('showApuracaoToAdmin', $apuracao->id)}}" title="Visualizar">
                        <i class="fa fa-search"></i> Visualizar
                    </a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6">Nenhuma apuração em aberto</td>
        </tr>
    @endif
    </tbody>
</table>
{{ $apuracoesPendentes->appends(request()->query())->links() }}
<div class="clearfix"></div>