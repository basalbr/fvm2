<div class="alert alert-info" style="display: block">
    <p><strong>Abaixo os dados empresariais que nos foram informados.</strong> Para alterar os dados nos envie uma mensagem.</p>
</div>
<table class="table table-striped table-hover">
    <tbody>
    <tr>
        <th scope="row">Etapa</th>
        <td>{{$aberturaEmpresa->getNomeEtapa()}}</td>
    </tr>
    <tr>
        <th scope="row">Status</th>
        <td>{{$aberturaEmpresa->getDescricaoEtapa()}}</td>
    </tr>
    <tr>
        <th scope="row">Nome preferencial</th>
        <td>{{$aberturaEmpresa->nome_empresarial1}}</td>
    </tr>
    <tr>
        <th scope="row">Natureza jurídica</th>
        <td>{{$aberturaEmpresa->naturezaJuridica->descricao}}</td>
    </tr>
    <tr>
        <th scope="row">Enquadramento</th>
        <td>{{$aberturaEmpresa->enquadramentoEmpresa->descricao}}</td>
    </tr>
    <tr>
        <th scope="row">Tipo de tributação</th>
        <td>{{$aberturaEmpresa->tipoTributacao->descricao}}</td>
    </tr>
    <tr>
        <th scope="row">Capital social</th>
        <td>{{$aberturaEmpresa->capital_social}}</td>
    </tr>
    <tr>
        <th scope="row">Endereço</th>
        <td>{{$aberturaEmpresa->getEnderecoCompleto()}}</td>
    </tr>
    <tr>
        <th scope="row">IPTU</th>
        <td>{{$aberturaEmpresa->iptu}}</td>
    </tr>
    <tr>
        <th scope="row">CPF/CNPJ Proprietário</th>
        <td>{{$aberturaEmpresa->cpf_cnpj_proprietario}}</td>
    </tr>
    <tr>
        <th scope="row">Área total ocupada em m²</th>
        <td>{{$aberturaEmpresa->area_ocupada}}</td>
    </tr>
    <tr>
        <th scope="row">Área total do imóvel m²</th>
        <td>{{$aberturaEmpresa->area_total}}</td>
    </tr>
    @if(count($aberturaEmpresa->cnaes))
        <tr>
            <th scope="row">Atividades</th>
            <td>
                @foreach($aberturaEmpresa->cnaes as $cnae)
                    <strong>{{$cnae->cnae->codigo}}</strong>
                    - {{$cnae->cnae->descricao}} {!! $aberturaEmpresa->cnaes->last() ? '<br />' : '' !!}
                @endforeach
            </td>
        </tr>
    @endif
    @if($aberturaEmpresa->cnae_duvida)
        <tr>
            <th scope="row">Observações CNAE</th>
            <td>{{$aberturaEmpresa->cnae_duvida}}</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>