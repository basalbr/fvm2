@extends('dashboard.layouts.master')
@section('top-title')
    Reuniões
@stop
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url(public_path().'vendor/css/fullcalendar.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url(public_path().'vendor/css/bootstrap-datepicker3.min.css')}}"/>
    @parent

@stop
@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'vendor/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{url(public_path().'vendor/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('.nav-button').on('click', function () {
                $('a[href="' + $(this).data('tab') + '"]').click();
            });
            $('#form-reuniao').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });
            $('.selecionar-horario').on('click', function () {
                $('.selecionar-horario').removeClass('active');
                $(this).addClass('active');
                $('#form-reuniao input[name="id_horario"]').remove();
                $('#form-reuniao').append('<input type="hidden" name="id_reuniao_horario" value="' + $(this).data('id') + '" />');
            });
            $('.datepicker').datepicker({
                autoclose: true,
                daysOfWeekDisabled: "0,6",
                //datesDisabled: [new Date(new Date().getTime() + 24 * 60 * 60 * 1000)],
                startDate: new Date(new Date().getTime() + 24 * 60 * 60 * 1000),
                language: "pt-BR",
                format: "dd/mm/yyyy"
            }).on('changeDate', function (e) {
                console.log(e.date.getDate())
            });
        });

        function validateFormPrincipal() {
            var formData = $('#form-reuniao').serializeArray();
            $.post($('#form-reuniao').data('validation-url'), formData)
                .done(function (data, textStatus, jqXHR) {
                    $('#form-reuniao').submit();
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422) {
                        //noinspection JSUnresolvedVariable
                        showFormValidationError($('#form-reuniao'), jqXHR.responseJSON);
                    } else {
                        showFormValidationError($('#form-reuniao'));
                    }
                });
        }
    </script>
@stop

@section('content')
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="alert-info alert" style="display: block">
                            <p><strong>Sabia que agora você pode conversar diretamente com seu contador?</strong> Para
                                isso
                                basta clicar no botão "Agendar Reunião" e escolher o dia e horário mais adequado para
                                você!</p>
                            <p>Nossas conversas são realizadas através de <strong>vídeo-chamadas por Skype</strong>.
                                Portanto lembre-se de que é necessário possuir o Skype intalado em seu computador ou
                                smartphone.</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <h4>Próximas reuniões</h4>
                <table class="table table-hovered table-striped">
                    <thead>
                    <tr>
                        <th>Data e horário</th>
                        <th>Assunto</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($reunioes->count())
                        @foreach($reunioes as $reuniao)
                        <tr>
                            <td>{{$reuniao->data->format('d/m/Y')}} {{$reuniao->horario->hora_inicial}} - {{$reuniao->horario->hora_final}} (<strong>{{$reuniao->quantoFalta()}}</strong>)</td>
                            <td>{!! $reuniao->assunto !!}</td>
                            <td>{!! $reuniao->getLabelStatus() !!} {!! $reuniao->pagamento->isPending() ? '<span class="label label-warning">Pagamento pendente</span>' : ''!!}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showReuniaoToUser', $reuniao->id)}}"
                                   title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                                @if($reuniao->pagamento->isPending())
                                    <a target="_blank" href="{{$reuniao->pagamento->getBotaoPagamento()}}"
                                       class="btn btn-success"><i class="fa fa-credit-card"></i>
                                        Pagar {{$reuniao->pagamento->formattedValue()}}</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">Você ainda não marcou nenhuma reunião, <a href="" data-toggle="modal"
                                                                                      data-target="#modal-agendar-reuniao">clique
                                    aqui</a> para solicitar uma reunião com seu contador.
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-agendar-reuniao"><i
                        class="fa fa-video-camera"></i> Agendar Reunião
            </button>
        </div>
    </div>
@stop
@section('modals')
    @parent
    <div class="modal animated fadeIn" id="modal-agendar-reuniao" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Selecione um dia e horário</h3>
                </div>
                <div class="modal-body">

                    <div class="col-xs-12">
                        <div class="alert alert-info" style="display: block; margin-bottom: 10px">
                            <h4 class="text-center"><strong>Como funciona?</strong></h4>
                            <ul>
                                <li>As reuniões tem duração de 45 minutos à partir do horário de início da mesma
                                </li>
                                <li>O valor de uma reunião é de R$149,90</li>
                                <li>Você irá conversar, através de vídeo-chamada no Skype, com o contador
                                    responsável
                                    pela sua empresa
                                </li>
                                <li>Após agendar a reunião será necessário aguardar a confirmação da mesma</li>
                                <li>Qualquer dúvida pode abrir um chamado para que possamos te auxiliar</li>
                            </ul>
                        </div>
                        <form method="POST" id="form-reuniao" action="{{route('newReuniao')}}"
                              data-validation-url="{{route('validateReuniao')}}">
                            @include('dashboard.components.form-alert')
                            @include('dashboard.components.disable-auto-complete')
                            <div class="clearfix"></div>

                            <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab-data" aria-controls="tab-data"
                                                                      role="tab"
                                                                      data-toggle="tab" disabled="disabled"><i
                                            class="fa fa-calendar"></i> Escolha a data</a></li>
                            <li role="presentation"><a href="#tab-horario" aria-controls="tab-horario" role="tab"
                                                       data-toggle="tab" disabled="disabled"><i
                                            class="fa fa-clock-o"></i> Escolha um horário</a>
                            </li>
                            <li role="presentation"><a href="#tab-assunto" aria-controls="tab-assunto" role="tab"
                                                       data-toggle="tab" disabled="disabled"><i
                                            class="fa fa-comment"></i> Assunto</a></li>
                            <li role="presentation"><a href="#tab-resumo" aria-controls="tab-resumo" role="tab"
                                                       data-toggle="tab" disabled="disabled"><i
                                            class="fa fa-file-o"></i> Resumo</a></li>
                        </ul>
                        <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tab-data">
                                    <div class="form-group">
                                        <label>Selecione uma data para a reunião</label>
                                        <input name="data" type="text" class="form-control date-mask datepicker"
                                               value="">
                                    </div>
                                    <div class="clearfix"></div>
                                    <button type="button" class="btn btn-primary pull-right nav-button"
                                            data-tab="#tab-horario"><i
                                                class="fa fa-clock-o"></i> Escolher um
                                        horário <i class="fa fa-angle-right"></i>
                                    </button>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab-horario">
                                    <div class="form-group">
                                        <label>Selecione um horário disponível</label>
                                        <div class="clearfix"></div>
                                        <br/>
                                        @if($horarios->count())
                                            @foreach($horarios as $horario)
                                                <button type="button" class="btn btn-default selecionar-horario"
                                                        data-id="{{$horario->id}}">{{$horario->hora_inicial}}
                                                    - {{$horario->hora_final}}</button>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="clearfix"></div>
                                    <button type="button" style="margin-left: 5px"
                                            class="btn btn-primary pull-right nav-button"
                                            data-tab="#tab-assunto"><i class="fa fa-comment"></i> Informar o assunto <i
                                                class="fa fa-angle-right"></i></button>
                                    <button type="button" class="btn btn-primary pull-right nav-button"
                                            data-tab="#tab-data"><i
                                                class="fa fa-angle-left"></i> <i class="fa fa-calendar"></i> Escolher
                                        uma
                                        data
                                    </button>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab-assunto">
                                    <div class="form-group">
                                        <label>Assunto</label>
                                        <textarea name="assunto" class="form-control"
                                                  placeholder="Por gentileza informe o assunto"></textarea>
                                    </div>
                                    <div class="clearfix"></div>
                                    <button type="button" style="margin-left: 5px"
                                            class="btn btn-primary pull-right nav-button"
                                            data-tab="#tab-resumo"><i class="fa fa-check"></i> Confirmar
                                        informações <i class="fa fa-angle-right"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary pull-right nav-button"
                                            data-tab="#tab-horario"><i
                                                class="fa fa-angle-left"></i> <i class="fa fa-clock-o"></i> Escolher um
                                        horário
                                    </button>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab-resumo">
                                    <p>Você gostaria de marcar uma reunião no dia <strong>28/08/2019</strong> no horário
                                        de
                                        <strong>10:00 - 10:45</strong> para tratar sobre <strong>"Gostaria de conhecer
                                            meu
                                            contador melhor"</strong>.</p>
                                    <p>O valor dessa reunião é de R$149,90 e só será confirmada após o pagamento.</p>
                                    <p>Confirma essas informações?</p>
                                    <div class="clearfix"></div>
                                    <button type="submit" style="margin-left: 5px"
                                            class="btn btn-success pull-right nav-button"
                                            data-tab="#messages"><i
                                                class="fa fa-check"></i> Sim, confirmo
                                    </button>
                                    <button type="button" class="btn btn-primary pull-right nav-button"
                                            data-tab="#tab-assunto"><i
                                                class="fa fa-angle-left"></i> <i class="fa fa-comment"></i> Informar o
                                        assunto
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="clearfix"></div>
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
