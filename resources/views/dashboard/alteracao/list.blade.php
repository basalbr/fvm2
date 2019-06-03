@extends('dashboard.layouts.master')
@section('top-title')
    Alterações de {{Auth::user()->empresas()->findOrFail($idEmpresa)->razao_social}}
@stop
@section('js')
    @parent
    <script type="text/javascript">
        var itens = {};
        $(function () {
            $('#lista-atividades .tipo-alteracao').on('click', function (e) {
                e.preventDefault();

                $(this).toggleClass('active');
                var id = parseInt($(this).data('id'));
                $('input[name="itens[]"]').each(function () {
                    parseInt($(this).val()) === id ? $(this).remove() : true;
                });
                if ($(this).hasClass('active')) {
                    $('#modal-nova-solicitacao form').append('<input type="hidden" value="' + id + '" name="itens[]" />');
                }
                refreshItens();
                calculaValorTotal();
                itens.itens.length > 0 ? $("#modal-nova-solicitacao .btn-success").removeClass('disabled').prop('disabled', false) : $("#modal-nova-solicitacao .btn-success").addClass('disabled').prop('disabled', true)
            });
        });

        function refreshItens(){
            itens.itens = [];
            $('input[name="itens[]"]').each(function () {
                itens.itens.push(parseInt($(this).val()));
            });
        }

        function calculaValorTotal() {
            $.post($('#lista-atividades').data('calcular-alteracao-url'), itens)
                .done(function (data, textStatus, jqXHR) {
                    $('#valor-alteracao').html(parseFloat(data).toFixed(2).replace(".", ","));
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422) {
                        //noinspection JSUnresolvedVariable
                        showFormValidationError($('#form-principal'), jqXHR.responseJSON);
                    } else {
                        showFormValidationError($('#form-principal'));
                    }
                });
        }
    </script>
@stop
@section('content')

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
            @if($alteracoesPendentes->count() > 0)
                @foreach($alteracoesPendentes as $alteracao)
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>{{$alteracao->getDescricao()}}</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div><strong>Razão social:</strong> {{$alteracao->empresa->razao_social}}</div>
                                <div><strong>Etapa do processo:</strong> {{$alteracao->getNomeEtapa()}}</div>
                                <div><strong>Status: </strong>{{$alteracao->getDescricaoEtapa()}}</div>
                                <div><strong>Solicitado em:</strong> {{$alteracao->created_at->format('d/m/Y')}}</div>
                            </div>
                            <div class="panel-footer">
                                @if($alteracao->pagamento->isPending())
                                    <a target="_blank" href="{{$alteracao->pagamento->getBotaoPagamento()}}"
                                       class="btn btn-success"><i class="fa fa-credit-card"></i>
                                        Pagar {{$alteracao->pagamento->formattedValue()}}</a>
                                @endif
                                <a class="btn btn-primary {{$alteracao->getQtdeMensagensNaoLidas() > 0 ? 'animated shake' : ''}}"
                                   href="{{route('showSolicitacaoAlteracaoToUser', [$alteracao->id])}}"
                                   title="Visualizar"><i class="fa fa-search"></i>
                                    Ver
                                    detalhes {!! $alteracao->getQtdeMensagensNaoLidas() > 0 ? ' <span class="label label-primary">Existem '.$alteracao->getQtdeMensagensNaoLidas().' mensagens não lidas</span>' : ''!!}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <strong>Você não solicitou nenhuma alteração ainda para essa empresa.</strong> <a
                                    href="" data-toggle="modal" data-target="#modal-nova-solicitacao">Clique aqui</a>
                            para solicitar uma nova alteração.
                        </div>
                    </div>
                </div>
            @endif
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">

            @if($alteracoesConcluidas->count())
                @foreach($alteracoesConcluidas as $alteracao)
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>{{$alteracao->getDescricao()}}</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div><strong>Razão social:</strong> {{$alteracao->empresa->razao_social}}</div>
                                <div><strong>Solicitado em:</strong> {{$alteracao->created_at->format('d/m/Y')}}
                                </div>
                            </div>
                            <div class="panel-footer">
                                <a class="btn btn-primary {{$alteracao->getQtdeMensagensNaoLidas() > 0 ? 'animated shake' : ''}}"
                                   href="{{route('showSolicitacaoAlteracaoToUser', [$alteracao->id])}}"
                                   title="Visualizar"><i class="fa fa-search"></i>
                                    Ver
                                    detalhes {!! $alteracao->getQtdeMensagensNaoLidas() > 0 ? ' <span class="label label-primary">Existem '.$alteracao->getQtdeMensagensNaoLidas().' mensagens não lidas</span>' : ''!!}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-xs-12">
                    @if(Auth::user()->empresas->count() > 0)

                        <div class="panel panel-default">
                            <div class="panel-body text-center">Não encontramos nenhuma solicitação de alteração
                                concluída
                            </div>
                        </div>
                    @else
                        <div class="panel panel-default">
                            <div class="panel-body text-center">É necessário migrar sua empresa antes de fazer a
                                alteração. <a
                                        href="{{route('newEmpresa')}}">Clique aqui para solicitar a migração da
                                    sua
                                    empresa</a>.
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    @if(Auth::user()->empresas->count()>0)
        <div class="navigation-options">
            <a class="btn btn-default" href="{{route('chooseEmpresaSolicitacaoAlteracao')}}"><i
                        class="fa fa-angle-left"></i> Voltar</a>
            <button type="button" class="btn btn-primary open-modal" data-modal="#modal-nova-solicitacao"><i
                        class="fa fa-plus"></i> Solicitar nova alteração
            </button>
        </div>
    @endif
@stop
@section('modals')
    @parent
    <div class="modal animated fadeInDown" id="modal-nova-solicitacao" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Solicitar nova alteração</h3>
                </div>
                <form action="{{route('newSolicitacaoAlteracao', $idEmpresa)}}" method="POST">
                    <div class="modal-body">
                        <div class="col-xs-12">
                            <p class="alert-info alert" style="display: block"><strong>Selecione uma ou mais
                                    alterações</strong> e clique em "Continuar".</p>
                        </div>
                        <div class="col-sm-7">
                            <div class="list-group" id="lista-atividades"
                                 data-calcular-alteracao-url="{{route('calcularValorAlteracao')}}">
                                @foreach($tiposAlteracao as $tipoAlteracao)
                                    <div class="tipo-alteracao"
                                       data-id="{{$tipoAlteracao->id}}">{{$tipoAlteracao->descricao}}</div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="circle"
                                 style="border-radius: 100%; width: 250px; text-align: center; background: rgba(0,0,0,0.02); padding: 55px 20px; margin-left: 20px">
                                <div class="circle-heading"
                                     style="color: #31708f; font-size: 25px; margin-top: 25px; font-weight: bold;">VALOR
                                    TOTAL
                                </div>
                                <div class="circle-pricing" style="color: #8BC34A; font-size: 20px; font-weight: bold;">
                                    R$<span id="valor-alteracao" style="color: #1E88E5; font-size: 60px">0,00</span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar
                        </button>
                        <button class="btn btn-success disabled" type="submit" disabled="disabled">Continuar <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
