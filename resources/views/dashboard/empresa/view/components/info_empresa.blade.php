<div class="alert alert-info" style="display: block">
    <p><strong>Abaixo os dados da sua empresa.</strong> Se precisar alterar alguma informação nos avise nas mensagens.</p>
</div>
<table class="table table-striped table-hover">
    <tbody>
    <tr>
        <th scope="row">Status</th>
        <td>{!! $empresa->getLabelStatus() !!}</td>
    </tr>
    <tr>
        <th scope="row">CNPJ</th>
        <td>{{$empresa->cnpj}}</td>
    </tr>
    <tr>
        <th scope="row">Razão Social</th>
        <td>{{$empresa->razao_social}}</td>
    </tr>
    <tr>
        <th scope="row">Nome Fantasia</th>
        <td>{{$empresa->nome_fantasia}}</td>
    </tr>
    <tr>
        <th scope="row">Sócio Principal</th>
        <td>{{$empresa->getSocioPrincipal()->nome}}</td>
    </tr>
    <tr>
        <th scope="row">Endereço</th>
        <td>{{$empresa->getEnderecoCompleto()}}</td>
    </tr>
    <tr>
        <th scope="row">Natureza Jurídica</th>
        <td>{{$empresa->naturezaJuridica->descricao}}</td>
    </tr>
    <tr>
        <th scope="row">Tributação</th>
        <td>{{$empresa->tipoTributacao->descricao}}</td>
    </tr>
    @if($empresa->inscricao_municipal)
        <tr>
            <th scope="row">Inscrição Municipal</th>
            <td>{{$empresa->inscricao_municipal}}</td>
        </tr>
    @endif
    @if($empresa->inscricao_estadual)
        <tr>
            <th scope="row">Inscrição Estadual</th>
            <td>{{$empresa->inscricao_estadual}}</td>
        </tr>
    @endif
    @if(count($empresa->cnaes))
        <tr>
            <th scope="row">Atividades</th>
            <td>
                @foreach($empresa->cnaes as $cnae)
                    <strong>{{$cnae->cnae->codigo}}</strong>
                    - {{$cnae->cnae->descricao}} {!! $empresa->cnaes->last() ? '<br />' : '' !!}
                @endforeach
            </td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>