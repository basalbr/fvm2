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
    <h1>Envio de Pró-Labore ({{$competenciaFormatada}})</h1>
    <hr>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab"><i
                        class="fa fa-info-circle"></i>
                Informações</a>
        </li>
        <li role="presentation">
            <a href="#pessoas" aria-controls="pessoas" role="tab" data-toggle="tab"><i
                        class="fa fa-users"></i>
                Pessoas</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            <form id="form-principal" method="POST" data-validation-url="{{route('validateProcessoFolha')}}"
                  enctype="multipart/form-data">
                {!! csrf_field() !!}
                @include('admin.components.form-alert')
                @include('admin.components.disable-auto-complete')
                <div class="col-sm-12">
                    <h3>Informações</h3>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Empresa</label>
                        <div class="form-control">{{$empresa->nome_fantasia}}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Razão Social</label>
                        <div class="form-control">{{$empresa->razao_social}}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>CNPJ</label>
                        <div class="form-control">{{$empresa->cnpj}}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Competência</label>
                        <div class="form-control">{{$competenciaFormatada}}</div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <input type="hidden" name="competencia" value="{{$competencia}}"/>
                <input type="hidden" name="id_empresa" value="{{$empresa->id}}"/>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Folha</label>
                        <div class="form-control">
                            <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                                Anexar Folha
                            </button>
                        </div>
                        <input data-validation-url="{{route('validateProcessoFolhaArquivo')}}"
                               data-upload-url="{{route('sendAnexoToTemp')}}" class="hidden upload-informacao-extra"
                               data-description="recibo_folha"
                               type='file' value=""/>

                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>INSS</label>
                        <div class="form-control">
                            <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                                Anexar INSS
                            </button>
                        </div>
                        <input data-validation-url="{{route('validateProcessoFolhaArquivo')}}"
                               data-upload-url="{{route('sendAnexoToTemp')}}"
                               data-description="inss" class="hidden upload-informacao-extra"
                               type='file' value=""/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>IRFF</label>
                        <div class="form-control">
                            <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                                Anexar IRRF
                            </button>
                        </div>
                        <input data-validation-url="{{route('validateProcessoFolhaArquivo')}}"
                               data-upload-url="{{route('sendAnexoToTemp')}}"
                               data-description="irrf" class="hidden upload-informacao-extra"
                               type='file' value=""/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>FGTS</label>
                        <div class="form-control">
                            <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                                Anexar FGTS
                            </button>
                        </div>
                        <input data-validation-url="{{route('validateProcessoFolhaArquivo')}}"
                               data-upload-url="{{route('sendAnexoToTemp')}}"
                               data-description="fgts" class="hidden upload-informacao-extra"
                               type='file' value=""/>
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="pessoas">
            @if($socios->count())
                <h3>Sócios que retiram pró-labore</h3>
                <table class="table table-hovered table-striped">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <div class="clearfix"></div>
                        @foreach($socios as $socio)
                            <tr>
                                <td>{{$socio->nome}}</td>
                                <td>{{$socio->getProLaboreFormatado()}}</td>
                                <td><button type="button" class="open-modal btn btn-primary" data-modal="#modal-socio-{{$socio->id}}"><i class="fa fa-search"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            @if($funcionarios->count())
                <h3>Funcionários</h3>
                    <table class="table table-hovered table-striped">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Valor</th>
                        </tr>
                        </thead>
                        <tbody>

                        <div class="clearfix"></div>
                        @foreach($funcionarios as $funcionario)
                            <tr>
                                <td>{{$funcionario->nome_completo}}</td>
                                <td>{{$funcionario->salario}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            @endif
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options animated slideInUp">
            <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
            <button class="btn btn-success" id="submit-form-principal"><i class="fa fa-check"></i> Concluir processo</button>
        </div>
        <div class="clearfix"></div>
    </div>
@stop

@section('modals')
    @parent
    @include('admin.components.socios.view', ['socios' => $socios])
@stop