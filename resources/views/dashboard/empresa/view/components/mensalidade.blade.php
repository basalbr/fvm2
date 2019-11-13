<table class="table table-striped table-hover">
    <tbody>
    <tr>
        <th scope="row">Valor</th>
        <td>{{$empresa->getMensalidadeAtual()->getValor()}}</td>
    </tr>
    <tr>
        <th scope="row">Limite de documentos fiscais emitidos/recebidos</th>
        <td>{{$empresa->getMensalidadeAtual()->qtde_documento_fiscal}}/mês</td>
    </tr>
    <tr>
        <th scope="row">Limite de funcionários</th>
        <td>{{$empresa->getMensalidadeAtual()->qtde_funcionario}}
            / {{$empresa->funcionarios()->where('status','ativo')->count()}} ativo(s)
        </td>
    </tr>
    </tbody>
</table>
<div class="clearfix"></div>