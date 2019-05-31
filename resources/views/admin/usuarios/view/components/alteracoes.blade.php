<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Tipo</th>
        <th>Etapa</th>
        <th>Aberto em</th>
        <th>Atualizado em</th>
        <th>Pagamento</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @if($alteracoes->count())
        @foreach($alteracoes as $alteracao)

            <tr>

                <td>{{$alteracao->getDescricao()}} {!! $alteracao->getLabelMensagensNaoLidasAdmin() !!}</td>
                <td>{!!$alteracao->getLabelEtapa()!!}</td>
                <td>{{$alteracao->created_at->format('d/m/Y à\s H:i')}}</td>
                <td>{{$alteracao->updated_at->format('d/m/Y à\s H:i')}}</td>
                <td>{!!$alteracao->pagamento->getLabelStatus()!!}</td>
                <td></td>
                <td>
                    <a class="btn btn-primary"
                       href="{{route('showSolicitacaoAlteracaoToAdmin', [$alteracao->id])}}"
                       title="Visualizar"><i class="fa fa-search"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">Nenhum chamado encontrado</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="clearfix"></div>