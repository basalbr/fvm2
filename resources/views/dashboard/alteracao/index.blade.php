@extends('dashboard.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Solicitações de alteração</h1>
        <hr>
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12">
        <div class="list-group">
            <button type="button" class="btn btn-primary open-modal" data-modal="#modal-nova-solicitacao"><i
                        class="fa fa-plus"></i> Clique aqui para cadastrar uma solicitação
            </button>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="panel">
        @if($alteracoes->count())
            @foreach($alteracoes as $alteracao)
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="items">
                            <div class="col-xs-12">
                                <i class="fa fa-info item-icon"></i>
                                <div class="item-value">{{$alteracao->tipo->descricao}}</div>
                                <div class="item-description">Tipo de solicitação</div>
                            </div>
                            <div class="col-xs-12">
                                <i class="fa fa-cogs item-icon"></i>
                                <div class="item-value">{{$alteracao->status}}</div>
                                <div class="item-description">Status da solicitação</div>
                            </div>
                            <div class="col-xs-12">
                                <i class="fa fa-credit-card item-icon"></i>
                                <div class="item-value">{{$alteracao->pagamento->status}}</div>
                                <div class="item-description">Status do Pagamento</div>
                            </div>
                            <div class="col-xs-12">
                                <i class="fa fa-envelope item-icon"></i>
                                <div class="item-value">Nenhuma nova mensagem</div>
                                <div class="item-link-description"><a href="">Ver mensagens <i
                                                class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-xs-12 options">
                            <a href="{{route('showSolicitacaoAlteracaoToUser', $alteracao->id)}}" class="btn btn-primary"><i
                                        class="fa fa-search"></i> Ver Detalhes</a>
                            <a href="" class="btn btn-danger"><i class="fa fa-remove"></i> Cancelar</a>
                        </div>
                        <div class="clearfix"></div>
                        <br/>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-xs-12">
                <h5>Você não fez nenhuma solicitação de alteração ainda.</h5>
            </div>
            <div class="clearfix"></div>
        @endif
    </div>

@stop
@section('modals')
    @parent
    <div class="modal animated fadeInDown" id="modal-nova-solicitacao" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Nova solitação</h3>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        <p>Escolha o tipo de solicitacão que você pretende fazer.</p>
                    </div>
                    <div class="col-xs-12">
                        <ul class="list-group">
                                @foreach($tiposAlteracao as $tipoAlteracao)
                                    <a class="list-group-item" href="{{route('newSolicitacaoAlteracao',[$tipoAlteracao->id])}}">{{$tipoAlteracao->descricao}} ({{$tipoAlteracao->getValorFormatado()}})</a>
                                @endforeach
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>
@stop
