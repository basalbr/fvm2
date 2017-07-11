<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Empresa</th>
        <th>Período</th>
        <th>Última mensagem</th>
        <th>Novas mensagens?</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($documentosContabeis as $processo)
        <tr>
            <td>{{$processo->empresa->nome_fantasia}}</td>
            <td>{{$processo->periodo->format('m/Y')}}</td>
            <td>{{$processo->getUltimaMensagem()}}</td>
            <td>{{$processo->getQtdeMensagensNaoLidas()}}</td>
            <td><a class="btn btn-primary"
                   href="{{route('showSolicitacaoAlteracaoToAdmin', [$solicitacao->id])}}"
                   title="Visualizar"><i class="fa fa-search"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="clearfix"></div>