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