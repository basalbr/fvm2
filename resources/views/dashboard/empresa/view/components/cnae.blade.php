<div class="alert alert-info" style="display: block">
    <p><strong>Abaixo a lista de atividades da sua empresa.</strong> Para alterar as atividades da sua empresa basta <a href="{{route('listSolicitacoesAlteracaoToUser', $empresa->id)}}">solicitar uma alteração de atividades.</a></p>
</div>
<table class="table table-striped table-hover">
    <tbody>
    @foreach($empresa->cnaes as $atividade)
        <tr>
            <th scope="row">{{$atividade->cnae->codigo}}</th>
            <td>{{$atividade->cnae->descricao}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="clearfix"></div>