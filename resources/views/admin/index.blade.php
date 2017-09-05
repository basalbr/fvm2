@extends('admin.layouts.master')
@section('top-title')
    <a href="{{route('adminHome')}}">Home</a>
@stop
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{url(public_path().'vendor/css/highcharts.css')}}"/>
@stop
@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'vendor/js/highcharts.js')}}"></script>
    <script type="text/javascript">
        function translateMonth(data) {
            monthArray = {
                'January': 'Janeiro',
                'February': 'Fevereiro',
                'March': 'Março',
                'April': 'Abril',
                'May': 'Maio',
                'June': 'Junho',
                'July': 'Julho',
                'August': 'Agosto',
                'September': 'Setembro',
                'October': 'Outubro',
                'November': 'Novembro',
                'December': 'Dezembro'
            }
            for (i in data) {
                data[i] = monthArray[data[i]];
            }
            return data
        }

        $(function () {
            $.getJSON($('#registered-users-history').data('url'), function (data) {
                Highcharts.chart('registered-users-history', {
                    chart: {
                        type: 'area'
                    },
                    xAxis: {
                        type: 'datetime',
                        dateTimeLabelFormats: { // don't display the dummy year
                            month: '%b',
                            year: '%b'
                        },
                        title: {
                            text: 'Date'
                        }
                    },
                    title: {
                        text: 'Conversões'
                    },
                    series: data
                });
            });
        })

    </script>
@stop
@section('content')
    <h3 class="text-center">Olá {{Auth::user()->nome}}, o que você precisa?</h3>

    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#alertas" aria-controls="alertas" role="tab" data-toggle="tab"><i class="fa fa-bell"></i>Alertas</a>
        </li>
        <li role="presentation">
            <a href="#graficos" aria-controls="graficos" role="tab" data-toggle="tab"><i class="fa fa-area-chart"></i>Gráficos</a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="active tab-pane animated fadeIn" id="alertas">
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
        </div>
        <div role="tabpanel" class="tab-pane" id="graficos">
            <div class="col-xs-12">
                <div class="panel">
                    <div id="registered-users-history" data-url="{{route('getRegisteredUsersHistory')}}"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

@stop