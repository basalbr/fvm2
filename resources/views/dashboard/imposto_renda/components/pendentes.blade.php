<div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
    @include('dashboard.imposto_renda.components.pendentes-filter')

    @if(count($irPendentes))
        @foreach($irPendentes as $ir)
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>{{$ir->declarante->nome}} ({{$ir->exercicio}})</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div><strong>Nome:</strong> {{$ir->declarante->nome}}</div>
                        <div><strong>Exercício:</strong> {{$ir->exercicio}}</div>
                        <div><strong>Última atualização:</strong> {{$ir->updated_at->format('d/m/Y')}}</div>
                        <div><strong>Status:</strong> {{$ir->getStatus()}}</div>
                        <div><strong>Novas mensagens:</strong> {{$ir->getQtdMensagensNaoLidas()}}</div>
                        @if($ir->isPending())
                            <div class="text-warning"><strong>Pagamento pendente</strong></div>
                        @endif
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-primary" href="{{route('showImpostoRendaToUser', [$ir->id])}}"
                           title="Visualizar"><i class="fa fa-search"></i> Visualizar</a>
                        @if($ir->isPending())
                            <a class="btn btn-success" href='{{$ir->pagamento->getBotaoPagamento()}}'
                               title="Pagar"><i class="fa fa-credit-card"></i> Pagar</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <strong>Não existe nenhuma declaração de Imposto de Renda em aberto</strong>, <a
                            href="{{route('newImpostoRenda')}}">clique
                        aqui</a>
                    para enviar uma declaração de Imposto de Renda.
                </div>
            </div>
        </div>
    @endif
</div>