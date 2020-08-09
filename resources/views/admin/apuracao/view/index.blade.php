@extends('admin.layouts.master')
@include('admin.components.annotation-menu', ['model'=>$apuracao])
@include('admin.components.tarefas.shortcut')
@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()

            $('.upload-file').on('click', function (e) {
                e.preventDefault();
                $(this).parent().next('.upload-informacao-extra').click();
            });

            $('.upload-informacao-extra').on('change', function () {
                validateAnexo($(this));
            });

            $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });

        });

        function validateFormPrincipal() {
            var formData = $('#form-principal').serializeArray();
            $.post($('#form-principal').data('validation-url'), formData)
                .done(function () {
                    $('#form-principal').submit();
                })
                .fail(function (jqXHR) {
                    if (jqXHR.status === 422) {
                        //noinspection JSUnresolvedVariable
                        showFormValidationError($('#form-principal'), jqXHR.responseJSON);
                    } else {
                        showFormValidationError($('#form-principal'));
                    }
                });
        }

        function validateAnexo(elem) {
            if (elem.val() !== '' && elem.val() && elem.val() !== undefined) {
                console.log(elem[0].files[0])
            }
            if ((elem[0].files[0].size / 1024) > 10240) {
                showModalAlert('O arquivo não pode ser maior que 10MB.');
                return false;
            }
            var formData = new FormData();
            formData.append('arquivo', elem[0].files[0]);
            $.post({
                url: elem.data('validation-url'),
                data: formData,
                contentType: false,
                processData: false
            }).done(function () {
                sendAnexo(elem)
            }).fail(function (jqXHR) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showModalAlert(jqXHR.responseJSON.arquivo);
                } else {
                    showModalAlert('Ocorreu um erro inesperado');
                }
            });
        }


        function sendAnexo(elem) {
            var formData = new FormData();
            formData.append('arquivo', elem[0].files[0]);
            formData.append('descricao', 'Guia');
            $.post({
                url: elem.data('upload-url'),
                data: formData,
                contentType: false,
                processData: false
            }).done(function (data) {
                elem.parent().find('.upload-file').prop('disabled', true).html('<i class="fa fa-check"></i> Arquivo enviado').removeClass('btn-primary').addClass('btn-disabled');
                appendAnexoToForm(elem.data('id'), data.filename);
            }).fail(function (jqXHR) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError(form, jqXHR.responseJSON);
                } else {
                    showFormValidationError(form);
                }
            });
        }

        function appendAnexoToForm(id, filename) {
            $('#form-principal').append($('<input />').attr({
                type: 'hidden',
                value: filename,
                name: 'guia'
            }));
        }

    </script>
@stop

@section('top-title')
    <a href="{{route('listApuracoesToAdmin')}}">Apurações</a> <i
            class="fa fa-angle-right"></i> {{$apuracao->imposto->nome}} - {{$apuracao->competencia->format('m/Y')}}
@stop

@section('content')

    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Informações e documentos enviados</strong></div>
            <div class="panel-body">
                @if($apuracao->guia)
                    <div class="col-xs-12">
                        <p class="alert alert-info visible-lg visible-sm visible-xs visible-md animated shake">Guia
                            já disponibilizada, <a
                                    href="{{asset(public_path().'storage/anexos/'. $apuracao->getTable() . '/'.$apuracao->id . '/' . $apuracao->guia)}}"
                                    download>clique aqui para baixar</a>.</p>
                    </div>
                    <div class="clearfix"></div>
                @endif
                <ul class="nav nav-tabs nav-tabs-mini" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab">Informações</a>
                    </li>
                    <li role="presentation">
                        <a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab">Documentos <span
                                    class="badge">{{$qtdeDocumentos}}</span></a>
                    </li>
                    <li role="presentation">
                        <a href="#observacoes" aria-controls="observacoes" role="tab" data-toggle="tab">Observações <span
                                    class="badge">{{$qtdeObservacoes}}</span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
                        @include('admin.apuracao.view.components.informacoes')
                    </div>
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="documentos">
                        @include('admin.apuracao.view.components.documentos')
                    </div>
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="observacoes">
                        @include('admin.apuracao.view.components.observacoes')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Mensagens</strong></div>
            <div class="panel-body" id="messages">
                @include('admin.components.chat.box2', ['model'=>$apuracao])</div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="navigation-space-tabless"></div>
    <div class="navigation-options animated slideInUp">
        <a class="btn btn-default" href="{{URL::previous()}}"><i
                    class="fa fa-angle-left"></i>
            Voltar</a>
        <button type="button" data-toggle="modal" data-target="#modal-realizar-acao" class="btn btn-primary"><i
                    class="fa fa-cogs"></i> Alterar Status / Enviar Guia
        </button>
    </div>
@stop
@section('modals')
    @parent
    @include('admin.apuracao.view.modals.realizar-acao')
@stop
