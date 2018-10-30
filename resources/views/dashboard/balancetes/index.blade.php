@extends('dashboard.layouts.master')
@section('top-title')
    Balancetes
@stop
@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'vendor/js/highcharts.js')}}"></script>
    <script type="text/javascript">
        var chart;
        $(function () {
            $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                chart.reflow()
            });
            $.getJSON($('#balance-history').data('url'), function (data) {
                Highcharts.setOptions({
                    lang: {
                        months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                        shortMonths: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
                    }
                });
                chart = Highcharts.chart('balance-history', {
                    chart: {
                        zoomType: 'x'
                    },

                    xAxis: {
                        type: 'datetime',
                        labels: {
                            formatter: function () {
                                return Highcharts.dateFormat('%b-%Y', this.value);
                            }
                        },
                        title: {
                            text: 'Mês'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true,
                                'color': '#0000CD'
                            }
                        },
                        column: {
                            dataLabels: {
                                align: 'center',
                                enabled: true,
                                color: '#000',
                                style: {fontWeight: 'bolder'},
                            }
                        }
                    },
                    yAxis: {
                        title: {text: 'Valor'}
                    },
                    title: {
                        text: 'Relatório contábil mensal'
                    },
                    series: data
                });
            });
        })

    </script>
@stop
@section('content')
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="panel-body active animated fadeIn">
            <p>{{Auth::user()->nome}}, neste local você irá encontrar os seus balancetes mensais, caso tenha algum
                problema ou dúvida basta <a href="{{route('newChamado')}}">entrar em contato através de um chamado</a>
                para que possamos lhe auxiliar.</p>
            <div id="balance-history" data-url="{{route('getBalanceHistory')}}"></div>
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Período inicial</th>
                    <th>Período final</th>
                    <th>Receitas</th>
                    <th>Despesas</th>
                    <th>Resultado do período</th>
                    <th>Download</th>
                </tr>
                </thead>
                <tbody>
                <div class="clearfix"></div>
                @if($balancetes->count())
                    @foreach($balancetes as $balancete)
                        <tr>
                            <td>
                                <a href="{{route('showEmpresaToUser', $balancete->id_empresa)}}">{{$balancete->empresa->razao_social}}</a>
                            </td>
                            <td>{{$balancete->getPeriodoInicial()}}</td>
                            <td>{{$balancete->getPeriodoFinal()}}</td>
                            <td>{{$balancete->getReceitas()}}</td>
                            <td>{{$balancete->getDespesas()}}</td>
                            <td>{!! $balancete->getResultadoPeriodo()!!}</td>
                            <td>
                                <a download class="btn btn-success"
                                   href="{{asset(public_path().'storage/balancetes/'. $balancete->id_empresa . '/'. $balancete->anexo)}}"
                                   title="Clique para fazer download do balancete"><i class="fa fa-download"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">Nenhum balancete disponível no momento, caso precise de algum balancete entre em
                            contato conosco <a href="{{route('newChamado')}}">através de um chamado</a>.
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="clearfix"></div>
@stop