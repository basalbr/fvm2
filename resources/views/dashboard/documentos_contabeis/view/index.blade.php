@extends('dashboard.layouts.master')

@section('js')
    @parent
    <script type="text/javascript">
        var anexoKey = 0;

        $(function () {

            $('tr').on('click', '.btn-primary', function (e) {
                e.preventDefault();
                $(this).parent().find('input').click();
            });

            $('tr input').on('change', function () {
                if (validateAnexo($(this))) {
                    sendAnexo($(this));
                }
            });

            $('tr').on('click', '.btn-danger', function (e) {
                e.preventDefault();
                removeAnexo($(this));
            });

            $('#form-anexo').on('submit', function (e) {
                e.preventDefault();
                validateFormAnexo();
            });
            $('#modal-remover-arquivo .btn-danger').on('click', function () {
                removeAnexo();
            });

            $('#update').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });

        });

        function validateAnexo(elem) {
            if (elem.val() !== '' &&
                elem.val() &&
                elem.val() !== undefined) {
                if ((elem[0].files[0].size / 1024) > 10240) {
                    showModalAlert('O arquivo não pode ser maior que 10MB.');
                    return false;
                }
                return true;
            } else {
                showModalAlert('É necessário escolher um arquivo para envio.');
                return false;
            }
        }

        function sendAnexo(elem) {
            elem.parent().find('.btn-primary').addClass('disabled').prop('disabled', true).html('<i class="fa fa-hourglass-1"></i> Enviando, aguarde...');
            var form = new FormData;
            form.append('arquivo', elem[0].files[0]);
            form.append('descricao', elem.data('name'));
            form.append('id_referencia', '1');
            form.append('referencia', 'processo_documento_contabil');
            $.post({
                url: elem.data('upload-url'),
                data: form,
                contentType: false,
                processData: false
            }).done(function (data) {
                elem.parent().find('.btn-primary, .btn-default').remove();
                elem.parent().prepend('<a class="btn btn-success" href="' + data.filepath + '" download target="_blank"><i class="fa fa-download"></i> Download</a>');
                var url = '{{ route("removeDocumentoContabil", [$processo->id, ":id"]) }}';
                url = url.replace(':id', data.id);
                elem.parent().append('<button class="btn btn-danger" data-url="' + url + '"><i class="fa fa-trash"></i> Remover arquivo</button>');
                showModalSuccess('Arquivo enviado com sucesso');
            }).fail(function (jqXHR) {
                elem.parent().find('.btn-primary').removeClass('disabled').prop('disabled', false).html('<i class="fa fa-upload"></i> Enviar arquivo');
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError(form, jqXHR.responseJSON);
                } else {
                    showFormValidationError(form);
                }
            });
        }

        function validateFormPrincipal() {
            if ($('tr').find('.btn-success').length < 1) {
                showModalAlert('É necessário anexar pelo menos um documento. Caso não tenha documentos para enviar, clique em "Sem movimento nesse período"');
                return false;
            }
            $('#form-principal').submit();
        }

        function showRemoveAnexoModal(descricao, id) {
            $('#modal-remover-arquivo .nome-arquivo').text(descricao);
            $('#modal-remover-arquivo .btn-danger').attr('data-url', anexo.parent().find('[name*="[arquivo]"]').val());
            $('#modal-remover-arquivo').modal('show');
        }

        function removeAnexo(elem) {
            $.get({
                url: elem.data('url')
            }).done(function (jqXHR) {
                elem.parent().find('a').remove();
                elem.parent().append('<button class="btn btn-primary"><i class="fa fa-upload"></i> Enviar arquivo</button>');
                elem.remove();
                showModalSuccess('Arquivo apagado com sucesso');
            }).fail(function (jqXHR) {
                showModalAlert('Ocorreu um erro ao tentar remover o arquivo, por favor abra um chamado e nos informe do problema para que possamos corrigir.');
            });
        }

    </script>
@stop
@section('top-title')
    <a href="{{route('listDocumentosContabeisToUser')}}">Documentos Contábeis</a> <i
            class="fa fa-angle-right"></i> {{$processo->empresa->nome_fantasia}} <i
            class="fa fa-angle-right"></i> Período de {{$processo->periodo->format('m/Y')}}
@stop
@section('content')
    @if($processo->isPending())
        @include('dashboard.documentos_contabeis.view.components.pendente')
    @else
        @include('dashboard.documentos_contabeis.view.components.enviado')
        @endif
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a class="btn btn-default" href="{{URL::previous()}}"><i
                    class="fa fa-angle-left"></i>
            Voltar</a>
        @if($processo->isPending())
            <button class="btn btn-success" type="button" id="update"><i class="fa fa-check"></i> Concluir
            </button>
            <a class="btn btn-danger" href="{{route('flagDocumentosContabeisAsSemMovimento', [$processo->id])}}"><i
                        class="fa fa-remove"></i> Sem movimento nesse período</a>
        @endif
    </div>
@stop


@section('modals')
    @parent
    <div class="modal animated fadeInDown" id="modal-remover-arquivo" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Remover arquivo</h3>
                </div>
                <div class="modal-body">
                    <p>Deseja remover o arquivo <span class="nome-arquivo"></span></p>
                    @include('dashboard.components.form-alert')
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-arquivo="" data-remove-url="{{route('removeAnexoFromTemp')}}"><i
                                class="fa fa-remove"></i> Sim, desejo remover
                    </button>
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>
@stop
