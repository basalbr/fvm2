<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Competência</th>
        <th>Descrição</th>
        <th>CNPJ</th>
        <th>Nome</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @if($empresa->apuracoes->count())
        @foreach($empresa->apuracoes()->orderBy('competencia', 'desc')->get() as $apuracao)

            <tr>
                <td>{{$apuracao->competencia->format('m/Y')}}</td>
                <td>{{$apuracao->imposto->nome}}</td>
                <td><a href="{{route('showEmpresaToAdmin', $apuracao->id_empresa)}}">{{$apuracao->empresa->cnpj}}</a></td>
                <td><a href="{{route('showEmpresaToAdmin', $apuracao->id_empresa)}}">{{$apuracao->empresa->razao_social}} ({{$apuracao->empresa->nome_fantasia}})</a></td>
                <td>{{$apuracao->status}}</td>
                <td>
                    <a class="btn btn-primary"
                       href="{{route('showApuracaoToAdmin', [$apuracao->id])}}"
                       title="Visualizar"><i class="fa fa-search"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">Nenhuma apuração encontrada</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>