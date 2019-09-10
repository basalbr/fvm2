<table class="table table-striped table-hover">
    <tbody>
    <tr>
        <th scope="row">Empresa</th>
        <td>
            <a href="{{route('showEmpresaToAdmin', $apuracao->empresa->id)}}">{{$apuracao->empresa->razao_social}}
                ({{$apuracao->empresa->nome_fantasia}})</a></td>
    </tr>
    <tr>
        <th scope="row">Usuário</th>
        <td>
            <a href="{{route('showUsuarioToAdmin', $apuracao->empresa->id_usuario)}}">{{$apuracao->empresa->usuario->nome}}</a>
        </td>
    </tr>
    <tr>
        <th scope="row">Imposto</th>
        <td>{{$apuracao->imposto->nome}}</td>
    </tr>
    <tr>
        <th scope="row">Competência</th>
        <td>{{$apuracao->competencia->format('m/Y')}}</td>
    </tr>
    <tr>
        <th scope="row">CNPJ</th>
        <td>{{preg_replace('/[^0-9]/','',$apuracao->empresa->cnpj)}}</td>
    </tr>
    <tr>
        <th scope="row">CPF</th>
        <td>{{preg_replace('/[^0-9]/','',$apuracao->empresa->getSocioPrincipal()->cpf)}}</td>
    </tr>
    <tr>
        <th scope="row">Código de Acesso</th>
        <td>{!! $apuracao->empresa->codigo_acesso_simples_nacional ?: "<span class='animated shake infinite label label-danger'>Não informado</span>" !!}</td>
    </tr>
    <tr>
        <th scope="row">Status</th>
        <td>{!! $apuracao->getLabelStatus() !!}</td>
    </tr>
    <tr>
        <th scope="row">Qtde Notas de Serviço</th>
        <td>{{$apuracao->qtde_notas_servico ?: 'Não informado'}}</td>
    </tr>
    <tr>
        <th scope="row">Qtde Notas de Entrada</th>
        <td>{{$apuracao->qtde_notas_entrada ?: 'Não informado'}}</td>
    </tr>
    <tr>
        <th scope="row">Qtde Notas de Saída</th>
        <td>{{$apuracao->qtde_notas_saida ?: 'Não informado'}}</td>
    </tr>
    @if($apuracao->guia)
        <tr>
            <th scope="row">Qtde Documentos Fiscais</th>
            <td>{{$apuracao->qtde_notas_saida + $apuracao->qtde_notas_entrada + $apuracao->qtde_notas_servico }}
                / {{$apuracao->empresa->getMensalidadeAtual()->qtde_documento_fiscal}}</td>
        </tr>
        <tr>
            <th>Guia da Apuração</th>
            <td>
                <a href="{{asset(public_path().'storage/anexos/'. $apuracao->getTable() . '/'.$apuracao->id . '/' . $apuracao->guia)}}"
                   download>Download</a>
            </td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>