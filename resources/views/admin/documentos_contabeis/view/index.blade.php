@extends('admin.layouts.master')

@section('js')
    @parent
    <script type="text/javascript">
        var anexoKey = 0;

        $(function () {
            $('#form-anexo').on('submit', function (e) {
                e.preventDefault();
                validateFormAnexo();
            });

            $('#descricao_arquivo').on('change', function () {
                if ($(this).val() == 'outro') {
                    $('#descricao_div').show();
                    $('[name="descricao"]').val(null);
                } else {
                    $('[name="descricao"]').val($(this).val());

                }
            });

            $('#modal-anexar-arquivo').on('hidden.bs.modal', function () {
                $(this).find('.alert').css('display', '').empty();
                $(this).find('.alert-warning').removeClass('alert-warning');
                $(this).find('form')[0].reset();
                $('#descricao_div').hide();
            });

            $('#anexos').on('click', '.remove', function () {
                showRemoveAnexoModal($(this).parent().parent());
            });


            $('#modal-remover-arquivo .btn-danger').on('click', function () {
                removeAnexo();
            });

            $('#update').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });

        });

        function validateFormPrincipal() {
            if ($('#anexos').find('.big-icon').length < 1) {
                showModalAlert('É necessário anexar pelo menos um documento. Caso não tenha documentos para enviar, clique em "Não houve movimentação nesse período');
                return false;
            }
            $('#form-principal').submit();
        }

        function validateFormAnexo() {
            if ($('#form-anexo').find('[name="arquivo"]').val() !== '' &&
                $('#form-anexo').find('[name="arquivo"]').val() &&
                $('#form-anexo').find('[name="arquivo"]').val() !== undefined) {
                if (($('#form-anexo [name="arquivo"]')[0].files[0].size / 1024) > 10240) {
                    showFormValidationError($('#form-anexo'), ['O arquivo não pode ser maior que 10MB.'])
                    return false;
                }
                var formData = new FormData();
                formData.append('arquivo', $('#form-anexo [name="arquivo"]')[0].files[0])
                var params = $('#form-anexo').serializeArray();
                $(params).each(function (index, element) {
                    formData.append(element.name, element.value);
                });
                sendAnexo($('#form-anexo'), formData, $('#form-principal'));
            } else {
                showFormValidationError($('#form-anexo'), ['É necessário escolher um arquivo para envio.'])
                return false;
            }
        }

        function sendAnexo(form, formData, targetForm) {
            $.post({
                url: form.data('anexo-temp-url'),
                data: formData,
                contentType: false,
                processData: false
            }).done(function (data) {
                $('#modal-anexar-arquivo').modal('hide');
                appendAnexoToForm(data.filename, formData.get('descricao'), targetForm, data.html);
            }).fail(function (jqXHR) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError(form, jqXHR.responseJSON);
                } else {
                    showFormValidationError(form);
                }
            });
        }

        function appendAnexoToForm(filename, description, targetForm, anexoContainer) {
            anexoContainer = $('<div class="col-sm-4 col-lg-3"></div>').html(anexoContainer);
            anexoContainer.find('.description').text(description).attr('title', description);

            anexoContainer.appendTo($('#anexos .list'));

            $('<input>').attr({
                name: 'anexos[' + anexoKey + '][arquivo]',
                type: 'hidden',
                value: filename
            }).appendTo(anexoContainer);

            $('<input>').attr({
                name: 'anexos[' + anexoKey + '][descricao]',
                type: 'hidden',
                value: description
            }).appendTo(anexoContainer);
            $('#anexos').removeClass('hidden');
            anexoKey++;
            showModalAlert('Arquivo enviado com sucesso, você pode visualizar os arquivos enviados na aba "Documentos Enviados"');
        }

        function showRemoveAnexoModal(anexo) {
            $('#modal-remover-arquivo .nome-arquivo').text(anexo.find('.description').text());
            $('#modal-remover-arquivo .btn-danger').attr('data-arquivo', anexo.parent().find('[name*="[arquivo]"]').val());
            $('#modal-remover-arquivo').modal('show');
        }

        function removeAnexo() {
            var arquivo = $('#modal-remover-arquivo .btn-danger').attr('data-arquivo');
            console.log(arquivo)
            $.post({
                url: $('#modal-remover-arquivo .btn-danger').data('remove-url'),
                data: {arquivo: arquivo}
            }).done(function () {
                $('#modal-remover-arquivo').modal('hide');
                $('[value="' + arquivo + '"]').parent().remove();
                if ($('#anexos .list div').length == 0) {
                    $('#anexos').addClass('hidden');
                }
            }).fail(function (jqXHR) {
                $('#modal-remover-arquivo').modal('hide');
                $('[value="' + arquivo + '"]').parent().remove();
                if ($('#anexos .list div').length == 0) {
                    $('#anexos').addClass('hidden');
                }
            });
        }

    </script>
@stop

@section('content')
    <h1>Envio de documentos contábeis ({{$processo->periodo->format('m/Y')}})</h1>
    <hr>
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.documentos_contabeis.view.components.tabs')
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            @include('admin.documentos_contabeis.view.components.informacoes')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="messages">
            @include('admin.components.chat.box', ['model'=>$processo])
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="docs">
            @include('admin.documentos_contabeis.view.components.docs')
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options animated slideInUp">
            <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
            @if($processo->isPending())
                <a class="btn btn-success" href="{{route('contabilizarDocumentoContabil', [$processo->id])}}"><i
                            class="fa fa-check"></i> Contabilizar</a>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
@stop