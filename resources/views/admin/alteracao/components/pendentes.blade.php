<div class="col-sm-12">
@include('admin.alteracao.components.pendentes-filter')
</div>
@if($alteracoesPendentes->count() > 0)
    @foreach($alteracoesPendentes as $alteracao)
        <div class="col-xs-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong><a
                                    href="{{route('showEmpresaToAdmin', $alteracao->id_empresa)}}">{{$alteracao->empresa->razao_social}}</a><br/> {{$alteracao->getDescricao()}}</strong></h3>
                </div>
                <div class="panel-body">
                    <div><strong>Razão social:</strong> <a
                                href="{{route('showEmpresaToAdmin', $alteracao->id_empresa)}}">{{$alteracao->empresa->razao_social}}</a>
                    </div>
                    <div><strong>Usuário:</strong> <a
                                href="{{route('showUsuarioToAdmin', $alteracao->id_usuario)}}">{{$alteracao->usuario->nome}}</a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="pull-left" style="margin-right: 5px"><strong>Última atualização em:</strong> {{$alteracao->updated_at->format('d/m/Y')}} ///</div>
                    <div class="pull-left" style="margin-right: 5px"><strong>Solicitado em:</strong> {{$alteracao->created_at->format('d/m/Y')}}</div>
                    <div class="clearfix"></div>
                    <div class="pull-left" style="margin-right: 5px"><span
                                class="label label-info">{{$alteracao->getNomeEtapa()}}</span></div>
                    @if($alteracao->pagamento->isPending())
                        <div class="animated shake pull-left" style="margin-right: 5px"><span
                                    class="label label-danger">Pagamento está pendente</span></div>
                    @endif
                    @if($alteracao->getQtdeMensagensNaoLidasAdmin() > 0)
                        <div class="animated shake pull-left" style="margin-right: 5px"><span
                                    class="label label-warning">{{$alteracao->getQtdeMensagensNaoLidasAdmin()}} {{$alteracao->getQtdeMensagensNaoLidasAdmin() == 1 ? 'mensagem não lida' : 'mensagens não lidas'}}</span>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-primary"
                       href="{{route('showSolicitacaoAlteracaoToAdmin', [$alteracao->id])}}" title="Visualizar">Visualizar</a>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body text-center">
                Nenhuma solicitação de alteração encontrada
            </div>
        </div>
    </div>
@endif
<div class="clearfix"></div>
{{ $alteracoesPendentes->appends(request()->query())->appends(['tab'=>'pendentes'])->links() }}
<div class="clearfix"></div>