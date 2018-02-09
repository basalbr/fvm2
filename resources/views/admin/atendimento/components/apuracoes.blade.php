<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Empresa</th>
        <th>Apuração</th>
        <th>Competência</th>
        <th>Última mensagem</th>
        <th>Novas mensagens?</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($apuracoes as $apuracao)
        <tr>
            <td>{{$apuracao->empresa->nome_fantasia}}</td>
            <td>{{$apuracao->imposto->nome}}</td>
            <td>{{$apuracao->competencia->format('m/Y')}}</td>
            <td>{{$apuracao->getUltimaMensagem()}}</td>
            <td>{{$apuracao->getQtdeMensagensNaoLidas()}}</td>
            <td><a class="btn btn-primary"
                   href="{{route('showApuracaoToAdmin', [$apuracao->id])}}"
                   title="Visualizar"><i class="fa fa-search"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $apuracoes->links() }}
<div class="clearfix"></div>