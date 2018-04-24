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
                uploadAnexo($(this), $(this).data('name'))
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

        function uploadAnexo(elem, name){
            if(validateAnexo(elem)){
                sendAnexo(elem, name)
            }else{
                showModalAlert('Ocorreu um erro interno, por favor avise o suporte.');
            }
        }

        function validateAnexo(elem) {
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


        function sendAnexo(elem, name) {
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
                appendAnexoToForm(elem.data('id'), data.filename, name);
            }).fail(function (jqXHR) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError(form, jqXHR.responseJSON);
                } else {
                    showFormValidationError(form);
                }
            });
        }

        function appendAnexoToForm(id, filename, name) {
            $('#form-principal').append($('<input />').attr({
                type: 'hidden',
                value: filename,
                name: name
            }));
        }

    </script>
@stop
<div role="tabpanel" class="tab-pane animated fadeIn" id="tab-admin">
    <div class="form-section">
            <p class="alert-info alert" style="display: block"><strong>Selecione o status da declaração e envie a declaração e o recibo da declaração do imposto de renda</strong></p>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option {{$ir->status == 'aguardando_conclusao' ? 'selected' : ''}} value="aguardando_conclusao">
                            Aguardando restante dos documentos
                        </option>
                        <option {{$ir->status == 'cancelado' ? 'selected' : ''}} value="cancelado">Cancelado</option>
                        <option {{$ir->status == 'concluido' ? 'selected' : ''}} value="concluido">Concluído</option>
                        <option {{$ir->status == 'em_analise' ? 'selected' : ''}} value="em_analise">Em Análise</option>

                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-control">
                        <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                            Anexar Recibo
                        </button>
                    </div>
                    <input data-validation-url="{{route('validateGuia')}}" data-name="recibo"
                           data-upload-url="{{route('sendAnexoToTemp')}}" class="hidden upload-informacao-extra"
                           type='file' value=""/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-control">
                        <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                            Anexar Declaração
                        </button>
                    </div>
                    <input data-validation-url="{{route('validateGuia')}}" data-name="declaracao"
                           data-upload-url="{{route('sendAnexoToTemp')}}" class="hidden upload-informacao-extra"
                           type='file' value=""/>
                </div>
            </div>
            <div class="col-sm-12">
                <button class="btn btn-success"><i class="fa fa-check"></i> Salvar alterações</button>
            </div>
    </div>
    <div class="clearfix"></div>
</div>