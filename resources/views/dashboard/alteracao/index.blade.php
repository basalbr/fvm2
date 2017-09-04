@extends('dashboard.layouts.master')
@section('top-title')
    Alterações
@stop
@section('content')

    <div class="col-xs-12">
        <div class="list-group">
            <button type="button" class="btn btn-primary open-modal" data-modal="#modal-nova-solicitacao"><i
                        class="fa fa-plus"></i> Clique aqui para cadastrar uma solicitação
            </button>
        </div>
    </div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Solicitações pendentes <span class="badge">{{$alteracoesPendentes->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
                Solicitações concluídas</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Tipo de alteração</th>
                    <th>Empresa</th>
                    <th>Status</th>
                    <th>Pagamento</th>
                    <th>Novas mensagens</th>
                    <th>Aberto em</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($alteracoesPendentes->count())
                    @foreach($alteracoesPendentes as $alteracao)

                        <tr>
                            <td>{{$alteracao->tipo->descricao}}</td>
                            <td>{{$alteracao->empresa->nome_fantasia}}</td>
                            <td>{{$alteracao->status}}</td>
                            <td>{{$alteracao->pagamento->status}}</td>
                            <td>{{$alteracao->mensagens->where('lida', '=', 0)->where('admin', '=', 1)->count()}}</td>
                            <td>{{$alteracao->created_at->format('d/m/Y')}}</td>
                            <td>
                                <a class="btn btn-primary"
                                   href="{{route('showSolicitacaoAlteracaoToUser', [$alteracao->id])}}"
                                   title="Visualizar"><i class="fa fa-search"></i></a>

                                @if($alteracao->pagamento->isPending())

                                    <a class="btn btn-success"
                                       href="{{$alteracao->pagamento->getBotaoPagamento()}}" title="Pagar"><i
                                                class="fa fa-credit-card"></i></a>

                                @endif

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="7">Nenhuma solicitação de alteração encontrada</td></tr>
                @endif
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Tipo de alteração</th>
                    <th>Empresa</th>
                    <th>Status</th>
                    <th>Última atualização</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($alteracoesConcluidas->count())
                    @foreach($alteracoesConcluidas as $alteracao)
                        <tr>
                            <td>{{$alteracao->tipo->descricao}}</td>
                            <td>{{$alteracao->empresa->nome_fantasia}}</td>
                            <td>{{$alteracao->status}}</td>
                            <td>{{$alteracao->updated_at->format('d/m/Y')}}</td>
                            <td>
                                <a class="btn btn-primary"
                                   href="{{route('showSolicitacaoAlteracaoToUser', [$alteracao->id])}}"
                                   title="Visualizar"><i class="fa fa-search"></i></a>
                            </td>
                        </tr>

                    @endforeach
                @else
                    <tr><td colspan="5">Nenhuma solicitação de alteração encontrada</td></tr>
                @endif
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

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
                                <a class="list-group-item"
                                   href="{{route('newSolicitacaoAlteracao',[$tipoAlteracao->id])}}">{{$tipoAlteracao->descricao}}
                                    ({{$tipoAlteracao->getValorFormatado()}})</a>
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
