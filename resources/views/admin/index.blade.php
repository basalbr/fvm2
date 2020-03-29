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
        var chart1, chart2;
        $(function () {
            $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                chart1.reflow()
                chart2.reflow()
            });
            $.getJSON($('#registered-users-history').data('url'), function (data) {
                chart1 = Highcharts.chart('registered-users-history', {
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
            $.getJSON($('#payment-history').data('url'), function (data) {
                chart2 = Highcharts.chart('payment-history', {
                    chart: {
                        type: 'column'
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
                    plotOptions: {
                        column: {
                            grouping: false,
                            shadow: false,
                            borderWidth: 0
                        }
                    },
                    title: {
                        text: 'Histórico de pagamentos'
                    },
                    series: data
                });
            });
        })

    </script>
    <script type="text/javascript">
        $(function () {
            $('#table-notifications a').on('click', function () {
                var text = $(this).text();
                $(this).remove('strong');
                $(this).text(text);
            });
            $('#form-notification-filter a').on('click', function (e) {
                e.preventDefault();
                $("#form-notification-filter [name='read']").val($(this).data('value'));
                $("#form-notification-filter").submit();
            })
        })
    </script>
@stop
@section('content')
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Notificações</div>
            <div class="panel-body">
                <form id="form-notification-filter" method="GET">
                    {!! csrf_field() !!}
                    <input type="hidden" name="read" value="all"/>

                    <a class="btn btn-link"
                       style="{{ !request()->has('read') || request()->get('read') == 'all' ? 'font-weight: bold' : ''}}"
                       data-value="all">Todas</a>
                    <a class="btn btn-link"
                       style="{{ request()->has('read') && request()->get('read') == 'read' ? 'font-weight: bold' : ''}}"
                       data-value="read">Lidas</a>
                    <a class="btn btn-link"
                       style="{{ request()->has('read') && request()->get('read') == 'unread' ? 'font-weight: bold' : ''}}"
                       data-value="unread">Não lidas</a>
                </form>
                <table class="table table-striped table-hover" id="table-notifications">
                    <tbody>
                    @foreach($notificacoes as $notificacao)
                        <tr>
                            <td><a class="linkless" href="{{route('lerNotificacao', [$notificacao->id])}}"
                                   target="_blank">
                                    <em>{{$notificacao->created_at->format('d/m/Y')}}
                                        - {{$notificacao->created_at->format('H:i:s')}}</em>
                                    <br/>
                                    {!! $notificacao->read_at ? $notificacao->data['mensagem'] : "<strong>".$notificacao->data['mensagem']."</strong>"!!}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $notificacoes->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Pendências</div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <a class="linkless" href="{{route('listSolicitacoesAlteracaoToAdmin')}}">
                                <p class="text-primary" style="font-size: 36px"><i class="fa fa-edit"></i></p>
                                <p class="text-primary"><span
                                            style="font-size: 20px; font-weight: bold">{{$alteracoesPendentes}}</span>
                                    alterações pendentes</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <a class="linkless" href="{{route('listApuracoesToAdmin')}}">
                                <p class="text-info" style="font-size: 36px"><i class="fa fa-calendar-o"></i></p>
                                <p class="text-info"><span
                                            style="font-size: 20px; font-weight: bold">{{$apuracoesPendentes}}</span>
                                    apurações pendentes</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <a class="linkless" href="{{route('listAberturaEmpresaToAdmin')}}">
                                <p class="text-success" style="font-size: 36px"><i class="fa fa-child"></i></p>
                                <p class="text-success"><span
                                            style="font-size: 20px; font-weight: bold">{{$aberturasPendentes}}</span>
                                    empresas para abrir</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <a class="linkless" href="{{route('listDocumentosContabeisToAdmin')}}">
                                <p class="text-warning" style="font-size: 36px"><i class="fa fa-copy"></i></p>
                                <p class="text-warning"><span
                                            style="font-size: 20px; font-weight: bold">{{$processosPendentes}}</span>
                                    balancetes para gerar</p>
                            </a>
                        </div>
                    </div>
                </div>
                @if(in_array(Auth::user()->id,[1, 57]))
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <a class="linkless" href="{{route('listOrdensPagamentoToAdmin')}}">
                                <p class="text-danger" style="font-size: 36px"><i class="fa fa-credit-card"></i></p>
                                <p class="text-danger"><span
                                            style="font-size: 20px; font-weight: bold">{{$pagamentosPendentes}}</span>
                                    pagamentos em aberto</p>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <a class="linkless" href="{{route('listImpostoRendaToAdmin')}}">
                                <p class="text-primary" style="font-size: 36px"><i class="fa fa-paw"></i></p>
                                <p class="text-primary"><span
                                            style="font-size: 20px; font-weight: bold">{{$irsPendentes}}</span>
                                    IRPFs para declarar</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <a class="linkless" href="{{route('listAtendimentosToAdmin')}}">
                                <p class="text-warning" style="font-size: 36px"><i class="fa fa-comments"></i></p>
                                <p class="text-warning"><span
                                            style="font-size: 20px; font-weight: bold">{{$chamadosPendentes}}</span>
                                    chamados para resolver</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(in_array(Auth::user()->id,[1, 57]))
        <div class="col-sm-6">
            <div class="panel panel-primary" id="graficos">
                <div class="panel-heading">Usuários/Aberturas/Migrações</div>
                <div class="panel-body">
                    <div id="payment-history" data-url="{{route('getPaymentHistory')}}"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary" id="graficos">
                <div class="panel-heading">Pagamentos</div>
                <div class="panel-body">
                    <div id="registered-users-history" style="width: 100%"
                         data-url="{{route('getRegisteredUsersHistory')}}"></div>
                </div>
            </div>
        </div>
    @endif
    <div class="clearfix"></div>


@stop