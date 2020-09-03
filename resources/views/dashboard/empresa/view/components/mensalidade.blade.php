<div class="alert alert-info" style="display: block">
    <p><strong>Abaixo os dados da sua mensalidade.</strong> Caso queira realizar alterações no seu plano nos informe através das mensagens.</p>
</div>
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
    <tr><td colspan="2"><a class="btn btn-info" type="button" data-toggle="modal" data-target="#modal-contrato-contabilidade"><i class="fa fa-file-o"></i> Ver contrato
            </a></td></tr>
    </tbody>
</table>
<div class="clearfix"></div>