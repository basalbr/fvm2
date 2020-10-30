<table class="table table-striped table-hover">
    <tbody>
    <tr>
        <th scope="row">Empresa</th>
        <td>
            <a href="{{route('showEmpresaToUser', $apuracao->empresa->id)}}">{{$apuracao->empresa->razao_social}}
                ({{$apuracao->empresa->nome_fantasia}})</a></td>
    </tr>
    <tr>
        <th scope="row">Competência</th>
        <td>{{$apuracao->competencia->format('m/Y')}}</td>
    </tr>
    <tr>
        <th scope="row">Status</th>
        <td>{!! $apuracao->getLabelStatus() !!}</td>
    </tr>
    @if($qtdeDocumentos > 0)
        @include('dashboard.apuracao.view.components.documentos')
    @endif
    <tr>
        <th>Retenção em saídas</th>
        <td>{{$apuracao->has_retencao_saida ? 'Sim' : 'Não'}}</td>
    </tr>
    <tr>
        <th>Retenção em entradas</th>
        <td>{{$apuracao->has_retencao_entrada ? 'Sim' : 'Não'}}</td>
    </tr>
    <tr></tr>

    </tbody>
</table>
<div class="clearfix"></div>