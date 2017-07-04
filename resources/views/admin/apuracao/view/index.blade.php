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
                    showModalAlert(jqXHR.responseJSON[0]);
                } else {
                    showModalAlert('Ocorreu um erro inesperado');
                }
            });
        }


        function sendAnexo(elem) {
            var formData = new FormData();
            formData.append('arquivo', elem[0].files[0]);
            formData.append('descricao', elem.parent().find('label').text());
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
                name: 'informacoes_extras[' + id + ']'
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
            <a href="#mensagens" aria-controls="mensagens" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Mensagens <span
                        class="badge">{{$apuracao->mensagens()->where('lida','=',0)->where('from_admin','=',0)->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#anexos" aria-controls="anexos" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i>
                Documentos enviados</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            <br/>
            <div class="list">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Empresa</label>
                        <div class="form-control">{{$apuracao->empresa->nome_fantasia}}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Imposto</label>
                        <div class="form-control">{{$apuracao->imposto->nome}}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Status da apuração</label>
                        <div class="form-control">{{$apuracao->status}}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Competência</label>
                        <div class="form-control">{{$apuracao->competencia->format('m/Y')}}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Vencimento</label>
                        <div class="form-control">{{$apuracao->vencimento->format('d/m/Y')}}</div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="mensagens">
            <div class="col-sm-12">
                @include('admin.components.chat.box', ['model'=>$apuracao])
            </div>
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="anexos">

            <div id="anexos">
                <br/>
                <div class="col-sm-12">
                    <p>Aqui estão os arquivos relacionados à esse processo.</p>
                </div>
                <div class="list">
                    @foreach($apuracao->informacoes as $informacao)
                        @if($informacao->tipo->tipo == 'anexo')
                            <div class="col-sm-4">
                                @include('admin.components.anexo.withDownload', ['anexo'=>$informacao->toAnexo()])
                            </div>
                        @endif
                    @endforeach
                    @foreach($apuracao->mensagens as $message)
                        @if($message->anexo)
                            <div class="col-sm-4">
                                @include('admin.components.anexo.withDownload', ['anexo'=>$message->anexo])
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="clearfix"></div>
            </div>

        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-sm-12">
            <a class="btn btn-default" href="{{route('listApuracoesToAdmin')}}"><i
                        class="fa fa-angle-left"></i>
                Voltar para apurações</a>
        </div>
        <div class="clearfix"></div>
    </div>
@stop
