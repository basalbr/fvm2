<div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
    @include('dashboard.imposto_renda.components.pendentes-filter')

@if(count($irPendentes))
        @foreach($empresas as $empresa)
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>{{$empresa->nome_fantasia}} ({{$empresa->razao_social}})</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div><strong>CNPJ:</strong> {{$empresa->cnpj}}</div>
                        <div><strong>Sócio principal:</strong> {{$empresa->getSocioPrincipal()->nome}}</div>
                        <div><strong>Status:</strong> {{$empresa->status}}</div>
                        <div>
                            <strong>Limite de documentos
                                fiscais:</strong> {{$empresa->getMensalidadeAtual()->qtde_documento_fiscal}}
                        </div>
                        <div>
                            <strong>Limite de
                                funcionários:</strong> {{$empresa->getMensalidadeAtual()->qtde_funcionario}}
                        </div>
                        <div><strong>Mensalidade: </strong>{{$empresa->getMensalidadeAtual()->getValor()}}</div>
                        <div><strong>Novas mensagens:</strong> {{$empresa->getQtdMensagensNaoLidas()}}</div>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-primary" href="{{route('showEmpresaToUser', [$empresa->id])}}"
                           title="Visualizar"><i class="fa fa-search"></i> Visualizar</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <strong>Não existe nenhuma declaração de Imposto de Renda em aberto</strong>, <a href="{{route('newImpostoRenda')}}">clique
                        aqui</a>
                    para enviar uma declaração de Imposto de Renda.
                </div>
            </div>
        </div>
    @endif
</div>