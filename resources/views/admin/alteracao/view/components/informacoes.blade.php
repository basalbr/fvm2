<table class="table table-striped table-hover">
    <tbody>
    <tr>
        <th scope="row">Descrição</th>
        <td>{{$alteracao->getDescricao()}}</td>
    </tr>
    <tr>
        <th scope="row">Empresa</th>
        <td>
            <a href="{{route('showEmpresaToAdmin', $alteracao->empresa->id)}}">{{$alteracao->empresa->razao_social}}</a></td>
    </tr>
    <tr>
        <th scope="row">Usuário</th>
        <td>
            <a href="{{route('showUsuarioToAdmin', $alteracao->empresa->id_usuario)}}">{{$alteracao->empresa->usuario->nome}}</a>
        </td>
    </tr>
    <tr>
        <th scope="row">Etapa</th>
        <td><span class="label label-info">{{$alteracao->getNomeEtapa()}}</span></td>
    </tr>
    <tr>
        <th scope="row">CNPJ <a target="_blank" href="http://servicos.receita.fazenda.gov.br/Servicos/cnpjreva/Cnpjreva_Solicitacao.asp?cnpj={{$alteracao->empresa->cnpj}}}"><i class="fa fa-external-link"></i></a></th>
        <td>{{$alteracao->empresa->cnpj}}
            <button class="btn-link btn-xs copy-to-clipboard"><i class="fa fa-clipboard"></i></button>
        </td>
    </tr>
    <tr>
        <th scope="row">CPF Sócio Principal</th>
        <td>{{$alteracao->empresa->getSocioPrincipal()->cpf}}
            <button class="btn-link btn-xs copy-to-clipboard"><i class="fa fa-clipboard"></i></button></td>
    </tr>
    @foreach($alteracao->informacoes as $informacao)
        @if($informacao->campo->tipo != 'file')
            <tr>
                    <th>{{$informacao->campo->nome}}</th>
                    <td>{{$informacao->valor}}</td>
            </tr>
        @endif
        @if($informacao->campo->tipo == 'file')
            <tr>
                    <th>{{$informacao->campo->nome}}</th>
                    <td><a download
                                                 href="{{asset(public_path().'storage/alteracao/'. $alteracao->id .'/'. $informacao->valor)}}"
                                                 title="Clique para fazer download do arquivo">Download</a></td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
<div class="clearfix"></div>
