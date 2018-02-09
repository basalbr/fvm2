<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Solicitação</th>
        <th>Última mensagem</th>
        <th>Novas mensagens?</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($solicitacoes as $solicitacao)
        <tr>
            <td>{{$solicitacao->usuario->nome}}</td>
            <td>{{$solicitacao->tipo->descricao}}</td>
            <td>{{$solicitacao->getUltimaMensagem()}}</td>
            <td>{{$solicitacao->getQtdeMensagensNaoLidas()}}</td>
            <td><a class="btn btn-primary"
                   href="{{route('showSolicitacaoAlteracaoToAdmin', [$solicitacao->id])}}"
                   title="Visualizar"><i class="fa fa-search"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $solicitacoes->links() }}
<div class="clearfix"></div>