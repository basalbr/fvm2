@extends('admin.layouts.master')

@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $('.upload-file').on('click', function (e) {
                e.preventDefault();
                $(this).parent().next('.upload-informacao-extra').click();
            });

            $('.upload-informacao-extra').on('change', function () {
                validateAnexo($(this));
            });

            $('#submit-form-principal').on('click', function (e) {
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
                appendAnexoToForm(elem.data('description'), data.filename);
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
                name: id
            }));
        }

    </script>
@stop

@section('content')
    <h1>Envio de Pró-Labore ({{$competencia}})</h1>
    <hr>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab"><i
                        class="fa fa-info-circle"></i>
                Informações</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            <form id="form-principal" method="POST" data-validation-url="{{route('validateProLabore')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @include('admin.components.form-alert')
                @include('admin.components.disable-auto-complete')
            <div class="col-sm-12">
                <h3>Informações</h3>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Empresa</label>
                    <div class="form-control">{{$socio->empresa->nome_fantasia}}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Nome do sócio</label>
                    <div class="form-control">{{$socio->nome}}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Valor de pró-labore</label>
                    <div class="form-control">{{$socio->getProLaboreFormatado()}}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Competência</label>
                    <div class="form-control">{{$competenciaFormatada}}</div>
                </div>
            </div>
            <div class="clearfix"></div>

                <input type="hidden" name="valor_pro_labore" value="{{$socio->pro_labore}}"/>
                <input type="hidden" name="competencia" value="{{$competencia}}"/>
                <input type="hidden" name="id_socio" value="{{$socio->id}}"/>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-control">
                            <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                                Anexar Pró-Labore
                            </button>
                        </div>
                        <input data-validation-url="{{route('validateGuiaProLabore')}}"
                               data-upload-url="{{route('sendAnexoToTemp')}}" class="hidden upload-informacao-extra"
                               data-description="pro_labore"
                               type='file' value=""/>

                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-control">
                            <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                                Anexar INSS
                            </button>
                        </div>
                        <input data-validation-url="{{route('validateGuia')}}"
                               data-upload-url="{{route('sendAnexoToTemp')}}"
                               data-description="inss" class="hidden upload-informacao-extra"
                               type='file' value=""/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-control">
                            <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                                Anexar IRRF
                            </button>
                        </div>
                        <input data-validation-url="{{route('validateGuia')}}"
                               data-upload-url="{{route('sendAnexoToTemp')}}"
                               data-description="irrf" class="hidden upload-informacao-extra"
                               type='file' value=""/>
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
        </div>
        <hr>
        <div class="col-sm-12">
            <a class="btn btn-default" href="{{route('listDocumentosContabeisToAdmin')}}"><i
                        class="fa fa-angle-left"></i>
                Voltar para documentos contábeis</a>
            <button class="btn btn-success" id="submit-form-principal"><i class="fa fa-save"></i> Salvar</button>
        </div>
        <div class="clearfix"></div>
    </div>
@stop