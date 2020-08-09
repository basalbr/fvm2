@extends('admin.layouts.master')
@include('admin.components.tarefas.shortcut')

@section('top-title')
    <a href="{{route('listBalancetesToAdmin')}}">Balancetes</a> <i class="fa fa-angle-right"></i> <a
            href="{{route('showEmpresaToAdmin', $balancete->id_empresa)}}">{{$balancete->empresa->razao_social}}
        ({{$balancete->empresa->nome_fantasia}})</a>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'vendor/js/highcharts.js')}}"></script>
    <script type="text/javascript">
        var chart;
        $(function(){
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
        });
    </script>
@stop

@section('content')
    <div class="panel">
        <div class="panel-body">
            <form class="form" method="POST" action="" id="form-principal">
                @include('admin.components.form-alert')
                @include('admin.components.disable-auto-complete')
                {{csrf_field()}}
                <div id="balance-history" data-url="{{route('getBalanceHistoryOfCompany', $balancete->empresa->id)}}"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Empresa</label>
                        <div class="form-control">
                            <a href="{{route('showEmpresaToAdmin', $balancete->id_empresa)}}">{{$balancete->empresa->razao_social}}
                                ({{$balancete->empresa->nome_fantasia}})</a>
                        </div>
                    </div>
                </div>
                @if($balancete->exercicio)
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Exercício</label>
                            <div class="form-control">
                                {{$balancete->exercicio->format('m/Y')}}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>De</label>
                            <div class="form-control">
                                {{$balancete->periodo_inicial->format('d/m/Y')}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Até</label>
                            <div class="form-control">
                                {{$balancete->periodo_final->format('d/m/Y')}}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Receitas</label>
                        <div class="form-control">{{$balancete->getReceitas()}}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Despesas</label>
                        <div class="form-control">{{$balancete->getDespesas()}}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Resultado do período</label>
                        <div class="form-control">{!! $balancete->getResultadoPeriodo() !!}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Balancete</label>
                        <div class="form-control">
                            <a download
                               href="{{asset(public_path().'storage/balancetes/'. $balancete->id_empresa . '/'. $balancete->anexo)}}"
                               title="Clique para fazer download do balancete">Download</a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
        <a href="{{route('deleteBalancete', $balancete->id)}}" class="btn btn-danger"><i class="fa fa-remove"></i>
            Remover</a>
    </div>
@stop