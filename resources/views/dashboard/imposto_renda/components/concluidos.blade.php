<div role="tabpanel" class="tab-pane animated fadeIn" id="concluidas">
    @if(count($irConcluidos))
        @foreach($irConcluidos as $ir)
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
                        <div><strong>Novas mensagens:</strong> {{$ir->getQtdMensagensNaoLidas(false)}}</div>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-primary" href="{{route('showImpostoRendaToUser', [$ir->id])}}"
                           title="Visualizar"><i class="fa fa-search"></i> Visualizar</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <strong>Não existe nenhuma declaração de Imposto de Renda concluído</strong>
                </div>
            </div>
        </div>
    @endif
</div>