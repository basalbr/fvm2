<table class="table table-striped table-hover">
    <tbody>
    <tr>
        <th scope="row">Criador</th>
        <td><a href="">{{$tarefa->criador()->nome}}</a></td>
    </tr>
    <tr>
        <th scope="row">Responsável</th>
        <td><a href="">{{$tarefa->responsavel()->nome}}</a></td>
    </tr>
    <tr>
        <th scope="row">Expectativa de conclusão</th>
        <td>{{$tarefa->expectativa_conclusao_em->format('d/m/Y à\s H:i')}}</td>
    </tr>
    <tr>
        <th scope="row">Status</th>
        <td>{!! $tarefa->getLabelStatus() !!}</td>
    </tr>
    <tr>
        <th scope="row">Assunto</th>
        <td>{{$tarefa->assunto}}</td>
    </tr>
    <tr>
        <th scope="row">Descrição</th>
        <td>{!! $tarefa->mensagem !!}</td>
    </tr>
    </tbody>
</table>
<div class="clearfix"></div>