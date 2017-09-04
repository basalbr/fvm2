@extends('admin.layouts.master')

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

@section('content')
    <h1>{{$apuracao->imposto->nome}}({{$apuracao->competencia->format('m/Y')}})</h1>
    <hr>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab"><i
                        class="fa fa-info-circle"></i>
                Informações</a>
        </li>
        <li role="presentation">
            <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Mensagens <span
                        class="badge">{{$apuracao->mensagens()->where('lida','=',0)->where('from_admin','=',0)->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#anexos" aria-controls="anexos" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i>
                Documentos enviados <span class="badge">{{$qtdeDocumentos}}</span></a>
        </li>
        @if($apuracao->guia)
            <li class="animated bounceInDown highlight">
                <a href="{{asset(public_path().'storage/anexos/'. $apuracao->getTable() . '/'.$apuracao->id . '/' . $apuracao->guia)}}"
                   download><i class="fa fa-download"></i> Guia</a>
            </li>
        @endif
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            @include('admin.apuracao.view.components.informacoes')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="messages">
            <div class="col-sm-12">
                @include('admin.components.chat.box', ['model'=>$apuracao])
            </div>
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="anexos">
            @include('admin.apuracao.view.components.documentos')
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="navigation-space"></div>
        <div class="navigation-options animated slideInUp">
            <a class="btn btn-default" href="{{URL::previous()}}"><i
                        class="fa fa-angle-left"></i>
                Voltar</a>
        </div>
        <div class="clearfix"></div>
    </div>
@stop
