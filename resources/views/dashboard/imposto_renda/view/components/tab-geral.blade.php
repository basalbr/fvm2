@section('js')
    @parent
    <script type="text/javascript">
        var fileId = 0;

        $(function () {
            refreshDocsCount();
            refreshLinkButtons();
            checkDeclaracaoAnoAnterior();
            //verifica se fez declaração ano anterior

            $('.link-file').on('click', function (e) {
                e.preventDefault();
                $(this).parent().find('.link-input').click();
            });
            $('.upload-file').on('click', function (e) {
                e.preventDefault();
                $(this).parent().find('.upload-input').click();
            });

            $('#form-principal .link-input').on('change', function () {
                uploadAndLinkFile($(this));
            });
            $('#form-principal .upload-input').on('change', function () {
                uploadFile($(this));
            });
            $('#form-principal .lista_documentos_enviados').on('click', '.btn-danger', function (e) {
                e.preventDefault();
                removeDoc($(this).parent().parent());
            });
            $('#modal-dependente form .link-input').on('change', function () {
                uploadAndLinkFile($(this), true);
            });
            $('#modal-dependente form .upload-input').on('change', function () {
                uploadFile($(this), true);
            });
            $('#modal-dependente form .lista_documentos_enviados').on('click', '.btn-danger', function (e) {
                e.preventDefault();
                removeDoc($(this).parent().parent(), true);
            });


            $('[name="fez_declaracao"]').on('change', function () {
                if ($(this).val() == '1') {
                    $('.ano_anterior_div').show();
                    $('.ano_anterior_div input').prop('disabled', false);
                    $('.documentos-declaracao').hide();
                    $('.documentos-declaracao input').prop('disabled', true);
                } else {
                    $('.ano_anterior_div').hide();
                    $('.ano_anterior_div input').prop('disabled', true);
                    $('.documentos-declaracao').show();
                    $('.documentos-declaracao input').prop('disabled', false);
                }
            });
        });

        function checkDeclaracaoAnoAnterior(){
            $('#form-principal .lista_documentos_enviados tr').each(function () {
                var docs = ['cpf', 'rg', 'titulo_eleitor', 'rg'];
                if (($(this).data('link') !== undefined && docs.indexOf($(this).data('link')) > -1) || $('[name="data_nascimento"]').val()) {
                    $('#form-principal [name="fez_declaracao"]').not('[value="1"]').prop('checked', true);
                    $('.ano_anterior_div').hide();
                    $('.ano_anterior_div input').prop('disabled', true);
                    $('.documentos-declaracao').show();
                    $('.documentos-declaracao input').prop('disabled', false);
                }
            });
        }

        function uploadFile(elem, dependente) {
            if (!dependente) {
                dependente = false;
            }
            var prefix = dependente ? '#modal-dependente form ' : '#form-principal ';
            if (validateFile(elem)) {
                var button = elem.parent().find('button');
                var formData = new FormData();
                formData.append('arquivo', elem[0].files[0]);

                if (dependente) {
                    formData.append('descricao', $(prefix + "[name='" + button.data('tipo') + "[descricao]']").val());
                } else {
                    formData.append('descricao', $(prefix + "[name='" + button.data('tipo') + "[descricao]']").val());
                }

                button.addClass('disabled').prop('disabled', true).html('<i class="fa fa-hourglass-1"></i> Enviando, aguarde...');

                $.post({
                    url: elem.data('upload-url'),
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function (data, textStatus, jqXHR) {
                    button.removeClass('disabled').prop('disabled', false).html('<i class="fa fa-upload"></i> Anexar Documento');
                    addRow(data.description, data.file, dependente);
                }).fail(function (jqXHR) {
                    if (jqXHR.status === 422) {
                        //noinspection JSUnresolvedVariable
                        var err = '';
                        for (i in jqXHR.responseJSON) {
                            err += jqXHR.responseJSON[i] + '\n';
                        }
                        showModalAlert(err);
                    } else {
                        showModalAlert('Ocorreu um erro inesperado');
                    }
                    button.removeClass('disabled').prop('disabled', false).html('<i class="fa fa-upload"></i> Anexar Documento');
                });
                elem.val(null);
                $(prefix + "input[name='" + button.data('tipo') + "[descricao]']").val(null);
                $(prefix + "select[name='" + button.data('tipo') + "[descricao]']").prop('selectedIndex', 0);
            }
        }

        function uploadAndLinkFile(elem, dependente) {
            if (!dependente) {
                dependente = false;
            }
            if (validateFile(elem)) {
                var button = elem.parent().find('button');
                var formData = new FormData();
                formData.append('arquivo', elem[0].files[0]);
                formData.append('descricao', elem.data('name'));
                button.addClass('disabled').prop('disabled', true).html('<i class="fa fa-hourglass-1"></i> Enviando, aguarde...');
                $.post({
                    url: elem.data('upload-url'),
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function (data, textStatus, jqXHR) {
                    button.removeClass('disabled').prop('disabled', false).html('<i class="fa fa-upload"></i> Anexar Documento');
                    addLinkRow(data.description, data.file, dependente);
                    elem.val(null);
                }).fail(function (jqXHR) {
                    if (jqXHR.status === 422) {
                        //noinspection JSUnresolvedVariable
                        var err = '';
                        for (i in jqXHR.responseJSON) {
                            err += jqXHR.responseJSON[i] + '\n';
                        }
                        showModalAlert(err);
                    } else {
                        showModalAlert('Ocorreu um erro inesperado');
                    }
                    button.removeClass('disabled').prop('disabled', false).html('<i class="fa fa-upload"></i> Anexar Documento');
                });
            }
        }

        function addRow(name, filename, dependente) {
            var prefix = dependente ? '#modal-dependente form ' : '#form-principal ';
            $(prefix + '.lista_documentos_enviados').find('.none').hide();
            $(prefix + '.lista_documentos_enviados').prepend('<tr class="animated fadeIn" data-id="' + fileId + '"><td>' + name + '</td><td><a href="" class="btn btn-danger"><i class="fa-remove fa"></i> Excluir</a></td></tr>')
            if (dependente) {
                $(prefix).append('<input type="hidden" name="[anexos][' + fileId + '][descricao]" value="' + name + '">');
                $(prefix).append('<input type="hidden" name="[anexos][' + fileId + '][arquivo]" value="' + filename + '">');
            } else {
                $(prefix).append('<input type="hidden" name="anexos[' + fileId + '][descricao]" value="' + name + '">');
                $(prefix).append('<input type="hidden" name="anexos[' + fileId + '][arquivo]" value="' + filename + '">');
            }
            fileId++;
            refreshDocsCount(dependente);
        }

        function addLinkRow(name, filename, dependente) {
            var prefix = dependente ? '#modal-dependente form ' : '#form-principal ';
            var description = $(prefix + 'input[data-name="' + name + '"]').parent().parent().find('label').text();
            $(prefix + '.lista_documentos_enviados').find('.none').hide();
            $(prefix + '.lista_documentos_enviados').prepend('<tr class="animated fadeIn" data-link="' + name + '"><td>' + description + '</td><td><a href="" class="btn btn-danger"><i class="fa-remove fa"></i> Excluir</a></td></tr>')
            $(prefix).append('<input type="hidden" name="' + name + '" value="' + filename + '">');
            refreshLinkButtons(dependente);
            refreshDocsCount(dependente);
        }

        function refreshLinkButtons(dependente) {
            var prefix = dependente ? '#modal-dependente form ' : '#form-principal ';
            $(prefix + '.link-input').each(function () {
                var button = $(this).parent().find('button');
                $(prefix + ".lista_documentos_enviados [data-link='" + $(this).data('name') + "']").length > 0 ? button.removeClass('btn-primary').addClass('btn-success').prop('disabled', true).html('<i class="fa fa-check"></i> Documento enviado') : button.removeClass('disabled', 'btn-success').addClass('btn-primary').prop('disabled', false).html('<i class="fa fa-upload"></i> Anexar Documento');
            });
        }

        function validateFile(elem) {
            if (elem.val() !== '' && elem.val() && elem.val() !== undefined) {

            } else {
                showModalAlert('É necessário escolher um arquivo.');
                return false;
            }
            if ((elem[0].files[0].size / 1024) > 10240) {
                showModalAlert('O arquivo não pode ser maior que 10MB.');
                return false;
            }
            return true;
        }

        function refreshDocsCount(dependente) {
            var prefix = dependente ? '#modal-dependente form ' : '#form-principal ';
            if (dependente) {
                var elem = $('a[href="#tab-modal-documentos-enviados"]');
            } else {
                var elem = $('a[href="#tab-documentos-enviados"]');
            }
            var badge = elem.find('.badge');
            var currentValue = parseInt(badge.text());
            if (($(prefix + ".lista_documentos_enviados tr").length - 1) !== currentValue) {
                elem.parent().addClass('bounceIn').one('webkitAnimationEnd oanimationend msAnimationEnd animationend',
                    function (e) {
                        $(this).removeClass('bounceIn');
                    }
                );
                badge.text($(prefix + ".lista_documentos_enviados tr").length - 1);
            }
            if ($(prefix + ".lista_documentos_enviados tr").length < 2) {
                $(prefix + ".lista_documentos_enviados .none").show();
            } else {
                $(prefix + ".lista_documentos_enviados .none").hide();
            }
        }

        function removeDoc(elem, dependente) {
            var prefix = dependente ? '#form-dependente ' : '#form-principal ';
            var anexos = dependente ? '[anexos]' : 'anexos';
            var remover = dependente ? '[remover][]' : 'remover[]';
            if (elem.data('link') !== undefined) {
                $(prefix + 'input[name="' + elem.data('link') + '"]').remove();
            }
            if (elem.data('id') !== undefined) {
                $(prefix + 'input[name^="' + anexos + '[' + elem.data('id') + ']"]').not('[class="anx"]').remove();
            }
            if (elem.data('anexo') !== undefined) {
                $(prefix).append('<input type="hidden" name="' + remover + '" value="' + elem.data('anexo') + '" />');
            }
            elem.remove();
            if ($(prefix + ".lista_documentos_enviados tr").length <= 1) {
                $(prefix + ".lista_documentos_enviados .none").show();
            }
            refreshLinkButtons(dependente);
            refreshDocsCount(dependente);
        }
    </script>
@stop
<div role="tabpanel" class="tab-pane active animated fadeIn" id="tab-geral">
    <p class="alert-info alert" style="display: block">Complete os dados com as informações solicitadas.<br/><strong>Campos
            com * são
            obrigatórios.</strong></p>

    <div class="col-md-6">
        <div class="form-group">
            <label class="">Fez declaração em {{$anoAnterior}}?</label>
            <div class="form-control">
                <div class="radio-inline">
                    <label class="control-label">
                        <input type="radio" name="fez_declaracao" value="1" checked/> Sim
                    </label>
                </div>
                <div class="radio-inline ">
                    <label class="control-label">
                        <input type="radio" name="fez_declaracao" value="0"/> Não
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Nome Completo *</label>
            <input name="nome" value="{{$ir->declarante->nome}}" class="form-control">
        </div>
    </div>
    <div class="ano_anterior_div">
        @include('dashboard.imposto_renda.view.components.upload', ['descricao'=>'Cópia do recibo da declaração de '.$anoAnterior, 'referencia'=>'recibo_anterior'])
        @include('dashboard.imposto_renda.view.components.upload', ['descricao'=>'Cópia da declaração de '.$anoAnterior, 'referencia'=>'declaracao_anterior'])
    </div>
    <div class="documentos-declaracao" style="display: none">
        @include('dashboard.imposto_renda.view.components.upload', ['descricao'=>'RG', 'referencia'=>'rg'])
        <div class="col-xs-12">
            <div class="form-group">
                <label>Data de Nascimento *</label>
                <input name="data_nascimento" value="{{$ir->declarante->getDataNascimento()}}"
                       class="form-control date-mask">
            </div>
        </div>
        @include('dashboard.imposto_renda.view.components.upload', ['descricao'=>'CPF', 'referencia'=>'cpf'])
        @include('dashboard.imposto_renda.view.components.upload', ['descricao'=>'Título de Eleitor', 'referencia'=>'titulo_eleitor'])
    </div>
    @include('dashboard.imposto_renda.view.components.upload', ['descricao'=>'Comprovante de Residência', 'referencia'=>'comprovante_residencia'])
    <div class="col-xs-12">
        <div class="form-group">
            <label>Ocupação *</label>
            <select class="form-control" name="id_ir_tipo_ocupacao">
                @foreach($tiposOcupacao as $ocupacao)
                    <option {{$ir->declarante->id_ir_tipo_ocupacao == $ocupacao->id ? 'selected="selected"' : ''}} value="{{$ocupacao->id}}">{{$ocupacao->descricao}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @include('dashboard.imposto_renda.view.components.text', ['descricao'=>'Descrição da Ocupação *', 'referencia'=>'ocupacao_descricao', 'valor'=>$ir->declarante->ocupacao])
    <div class="clearfix"></div>
</div>