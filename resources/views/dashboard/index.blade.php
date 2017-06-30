@extends('dashboard.layouts.master')
@section('content')
    <h3 class="text-center">Olá {{Auth::user()->nome}}, o que você precisa?</h3>
    @if(!Auth::user()->empresas->count() && !Auth::user()->aberturasEmpresa->count())
        <div class="col-sm-6">
            <a href="{{route('newAberturaEmpresa')}}" class="atalho">
                <i class="fa fa-child"></i> Quero <strong>abrir uma empresa</strong>
            </a>
        </div>
        <div class="col-sm-6">
            <a href="{{route('newEmpresa')}}" class="atalho verde">
                <i class="fa fa-exchange"></i> Desejo <strong>migrar minha empresa</strong> para cá
            </a>
        </div>
        <div class="clearfix"></div>
    @endif
    @if(Auth::user()->empresas->count())
        <div class="col-sm-6">
            <a href="{{route('listEmpresaToUser')}}" class="atalho verde">
                <i class="fa fa-building"></i> Quero verificar os dados da <strong>minha empresa</strong>
            </a>
        </div>
        <div class="col-sm-6">
            <a href="{{route('listApuracoesToUser')}}" class="atalho verde">
                <i class="fa fa-calendar-check-o"></i> Quero ver minhas <strong>apurações</strong>
            </a>
        </div>
        <div class="col-sm-6">
            <a href="{{route('listDocumentosContabeisToUser')}}" class="atalho verde">
                <i class="fa fa-files-o"></i> Quero ver meus <strong>documentos contábeis</strong>
            </a>
        </div>
    @endif
    <div class="col-sm-6">
        <a href="{{route('listSolicitacoesAlteracaoToUser')}}" class="atalho verde">
            <i class="fa fa-bullhorn"></i> Quero solicitar uma <strong>alteração</strong>
        </a>
    </div>
    @if(Auth::user()->ordensPagamento->count())
        <div class="col-sm-6">
            <a href="{{route('listOrdensPagamentoToUser')}}" class="atalho verde">
                <i class="fa fa-credit-card"></i> Quero ver meus <strong>pagamentos</strong>
            </a>
        </div>
    @endif
    <div class="col-sm-6">
        <a href="{{route('listAtendimentosToUser')}}" class="atalho verde">
            <i class="fa fa-comments"></i> Preciso de <strong>atendimento</strong>
        </a>
    </div>
    <div class="clearfix"></div>
    <hr>
    @if(($pagamentosPendentes + $apuracoesPendentes + $processosPendentes) > 0)
    <div class="col-sm-6">
        <h3 class="text-center animated shake">Atenção</h3>
        <div class="col-sm-12">
            @if($pagamentosPendentes)
                <div class="col-sm-12">
                    <a href="{{route('listOrdensPagamentoToUser')}}" class="alerta animated shake">
                        Você possui {{$pagamentosPendentes}} pagamentos em aberto
                    </a>
                </div>
            @endif
            @if($apuracoesPendentes)
                <div class="col-sm-12">
                    <a href="{{route('listApuracoesToUser')}}" class="alerta animated shake">
                        Você possui {{$apuracoesPendentes}} apurações pendentes
                    </a>
                </div>
            @endif
            @if($processosPendentes)
                <div class="col-sm-12">
                    <a href="{{route('listDocumentosContabeisToUser')}}" class="alerta animated shake">
                        Precisamos que envie seus documentos contábeis
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endif
    @if(Auth::user()->unreadNotifications->count())
    <div class="col-sm-6">
        <h3 class="text-center">Notificações</h3>
        @foreach(Auth::user()->unreadNotifications as $notification)
            <div class="col-sm-12">
                <a href="{{route('lerNotificacao', [$notification->id])}}" class="notification">
                    {{$notification->data['mensagem']}}
                </a>
            </div>
        @endforeach
    </div>
@endif
@stop