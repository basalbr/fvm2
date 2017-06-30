@extends('dashboard.layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url(public_path().'vendor/css/fullcalendar.min.css')}}"/>
    @parent

@stop
@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'vendor/js/moment.min.js')}}"></script>
    <script type="text/javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.0/lang/pt-br.js"></script>
    <script type="text/javascript">

        $(function () {
            $('#calendar').fullCalendar({
                height: 'auto',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                lang: 'pt-br',
                events: {
                    url: $('#calendar').data('impostos-url'),
                    type: 'POST'
                },
                eventClick: function (calEvent) {
                    $('.fc-event').each(function () {
                        $(this).removeClass('fc-event-success');
                    });
                    $(this).addClass('fc-event-success');
                    $.get($('#calendar').data('instrucoes-url'), {'id': calEvent.id}, function (data) {
                        if (data.length !== undefined) {
                            if (data.length > 0) {
                                $('.modal-header').text(calEvent.title)
                                var html = "<div class='col-xs-12'>\n\
                                    <input type='hidden' id='instrucao-page' value='1' />\n\
                                    <input type='hidden' id='instrucao-total' value='" + data.length + "' />";
                                html += '<h2 style="margin-bottom:15px; margin-top:0; padding:0;">' + calEvent.title + '</h2>';
                                if (data.length > 1) {
                                    html += "<div id='paginacao-instrucao-container'>";
                                    html += "<div class='paginacao-instrucao'>Página <span id='pagina-atual' class='numero'>1</span> de <span class='numero'>" + data.length + "</span></div>";
                                    html += "<div class='paginacao-botoes'>";
                                    html += "<div class='btn btn-primary disabled btn-instrucao-voltar' style='margin-right: 5px'>Voltar</div>";
                                    html += "<div class='btn btn-primary btn-instrucao-avancar'>Avançar</div>";
                                    html += "</div>";
                                    html += "<div class='clearfix'></div>";
                                    html += "</div>";
                                }
                                html += "</div>";
                                data.forEach(function (instrucao, key) {
                                    if (key == 0) {
                                        html += "<div class='col-xs-12 instrucao-descricao' style='display: block' data-pagina='" + (key + 1) + "'>";
                                    } else {
                                        html += "<div class='col-xs-12 instrucao-descricao' style='display: none' data-pagina='" + (key + 1) + "'>";
                                    }
                                    html += instrucao.descricao;
                                    html += "</div>";
                                }, html);

                                $('.modal-body > p').html(html);
                                $('#imposto-modal').modal('show');
                            }
                        }
                    })
                }
            });

        });

    </script>
@stop
@section('content')
    <div class="col-xs-12">
        <h1>Calendário de impostos</h1>
        <p>Aqui você encontra o calendário com quais impostos e quando que empresas do Simples Nacional devem pagar.</p>
        <hr>
    </div>
    <div class="col-sm-12">
        <div class="panel">
            <div id="calendar" data-impostos-url="{{route('getImpostos')}}"
                 data-instrucoes-url="{{route('getDetailsImposto')}}"></div>
        </div>
    </div>
    <div class="clearfix"></div>
@stop
@section('modals')
    @parent
    <div class="modal fade" id="imposto-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title"></h4>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-body">
                    <p></p>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@stop