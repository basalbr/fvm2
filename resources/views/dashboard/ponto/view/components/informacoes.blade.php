<table class="table table-striped table-hover">
    <tbody>
    <tr>
        <th scope="row">Empresa</th>
        <td>
            <a href="{{route('showEmpresaToUser', $ponto->empresa->id)}}">{{$ponto->empresa->razao_social}}
                ({{$ponto->empresa->nome_fantasia}})</a></td>
    </tr>
    <tr>
        <th scope="row">Competência</th>
        <td>{{$ponto->periodo->format('m/Y')}}</td>
    </tr>
    <tr>
        <th scope="row">Status</th>
        <td>{!! $ponto->getLabelStatus() !!}</td>
    </tr>
    </tbody>
</table>
<div class="clearfix"></div>
@foreach($ponto->empresa->funcionarios()->orderBy('status')->get() as $funcionario)
    <div class="form-group">
        @if($funcionario->getInformacaoByPonto($ponto->id)->count())
            <p>
                <a href="{{route('showFuncionarioToUser', [$funcionario->empresa->id, $funcionario->id])}}"><strong>{{$funcionario->nome_completo}}</strong></a>
            </p>
            <div class="clearfix"></div>
            <table class="table table-striped table-hover">
                <tbody>
                @foreach($funcionario->getInformacaoByPonto($ponto->id)->get() as $informacao)
                    <tr>
                        <th scope="row">{{$informacao->nome}}</th>
                        <td>{{$informacao->descricao}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>
                <a href="{{route('showFuncionarioToUser', [$funcionario->empresa->id, $funcionario->id])}}"><strong>{{$funcionario->nome_completo}}</strong></a>
                <label class="label label-warning">Nenhuma informação enviada</label>{!! $funcionario->status == 'demitido' ? '<label class="label label-danger">Demitido</label>' : '' !!} {!! $funcionario->status == 'pendente' ? '<label class="label label-primary">Pendente</label>' : '' !!}</p>
        @endif
    </div>
@endforeach
<div class="clearfix"></div>