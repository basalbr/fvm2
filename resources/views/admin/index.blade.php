@extends('admin.layouts.master')
@section('top-title')
    <a href="{{route('adminHome')}}">Home</a>
@stop
@section('content')
    <h3 class="text-center">Olá {{Auth::user()->nome}}, o que você precisa?</h3>

    @if(($pagamentosPendentes + $apuracoesPendentes + $processosPendentes) > 0)
        <div class="col-sm-6">
            <h3 class="text-center animated shake">Atenção</h3>
            <div class="col-sm-12">
                @if($alteracoesPendentes)
                    <div class="col-sm-12">
                        <a href="{{route('listSolicitacoesAlteracaoToAdmin')}}" class="alerta animated shake">
                            Existem {{$alteracoesPendentes}} alterações já pagas em aberto
                        </a>
                    </div>
                @endif
                @if($pagamentosPendentes)
                    <div class="col-sm-12">
                        <a href="{{route('listOrdensPagamentoToAdmin')}}" class="alerta animated shake">
                            Existem {{$pagamentosPendentes}} pagamentos em aberto
                        </a>
                    </div>
                @endif
                @if($apuracoesPendentes)
                    <div class="col-sm-12">
                        <a href="{{route('listApuracoesToAdmin')}}" class="alerta animated shake">
                            Possuímos {{$apuracoesPendentes}} apurações pendentes
                        </a>
                    </div>
                @endif
                @if($processosPendentes)
                    <div class="col-sm-12">
                        <a href="{{route('listDocumentosContabeisToAdmin')}}" class="alerta animated shake">
                            Existem {{$processosPendentes}} solicitações de documentos contábeis em aberto
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