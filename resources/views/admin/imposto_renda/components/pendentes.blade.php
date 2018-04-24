<div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
    @include('admin.imposto_renda.components.pendentes-filter')

@if(count($irPendentes))
        @foreach($irPendentes as $ir)
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>{{$ir->declarante->nome}} ({{$ir->exercicio}})</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div><strong>Usuário:</strong> <a href="{{route('showUsuarioToAdmin', $ir->id_usuario)}}">{{$ir->usuario->nome}}</a></div>
                        <div><strong>Nome:</strong> {{$ir->declarante->nome}}</div>
                        <div><strong>Exercício:</strong> {{$ir->exercicio}}</div>
                        <div><strong>Última atualização:</strong> {{$ir->updated_at->format('d/m/Y')}}</div>
                        <div><strong>Status:</strong> {{$ir->getStatus()}}</div>
                        <div><strong>Status Pagamento:</strong> {{$ir->getPaymentStatus()}}</div>
                        <div><strong>Novas mensagens:</strong> {{$ir->getQtdMensagensNaoLidas(true)}}</div>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-primary" href="{{route('showImpostoRendaToAdmin', [$ir->id])}}"
                           title="Visualizar"><i class="fa fa-search"></i> Visualizar</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <strong>Não existe nenhuma declaração de Imposto de Renda em aberto</a>
                </div>
            </div>
        </div>
    @endif
</div>