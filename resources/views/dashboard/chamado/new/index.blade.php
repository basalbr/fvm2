@extends('dashboard.layouts.master')

@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });

            $('#form-anexo').on('submit', function (e) {
                e.preventDefault();
                validateFormAnexo();

            });

            $('#modal-anexar-arquivo').on('hidden.bs.modal', function () {
                $(this).find('.alert').empty();
                $(this).find('form')[0].reset();
            })
        });

        var anexoKey = 0;

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
                appendAnexoToForm(data.filename, formData.get('descricao'), targetForm);
            }).fail(function (jqXHR) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError(form, jqXHR.responseJSON);
                } else {
                    showFormValidationError(form);
                }
            });
        }

        function appendAnexoToForm(filename, description, targetForm) {
            var anexoContainer = $('<div>').addClass('col-sm-4');
            anexoContainer.append(
                $('<div>').addClass('anexo').append(
                    $('<div>').addClass('remove').append(
                        $('<button>').attr({
                            'type': 'button',
                            'class': 'btn btn-danger'
                        }).append(
                            $('<i>').addClass('fa fa-remove')
                        )
                    )).append(
                    $('<div>').addClass('description').text(description)
                ).append(
                    $('<div>').addClass('clearfix')
                ));

            anexoContainer.appendTo(targetForm.find('#anexos .list'));

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
        }

    </script>
@stop

@section('content')
    <h1>Chamado</h1>
    <hr>
    <div class="panel">
        <div class="col-sm-12">
            <h3>Abrir chamado</h3>
            <p>Campos com * são obrigatórios.</p>

            <br/>
        </div>
        <form class="form" method="POST" action="" id="form-principal"
              data-validation-url="{{route('validateChamado')}}">
            @include('dashboard.components.form-alert')
            @include('dashboard.components.disable-auto-complete')
            {{csrf_field()}}

            <div class="col-sm-12">
                <div class="form-group">
                    <label>Assunto *</label>
                    <select class="form-control" name="id_tipo_chamado">
                        <option value="">Escolha uma opção</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Mensagem *</label>
                    <textarea class="form-control" name="mensagem"></textarea>
                </div>
            </div>
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary open-modal" data-modal="#modal-anexar-arquivo"><i
                            class="fa fa-paperclip"></i> Clique para anexar um arquivo
                </button>
            </div>
            <div class="clearfix"></div>
            <br/>
            <div id="anexos">
                <div class="col-sm-12">
                    <h4>Anexos</h4>
                </div>
                <div class="list">

                </div>
                <div class="clearfix"></div>

            </div>
            <hr>
            <div class="col-sm-12">
                <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>

                <button type="submit" class="btn btn-success"><i class="fa fa-envelope"></i> Abrir chamado</button>
            </div>
        </form>
        <div class="clearfix"></div>
        <br/>
    </div>
@stop

@section('modals')
    @parent
    <div class="modal animated fadeInDown" id="modal-anexar-arquivo" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Anexar arquivo</h3>
                </div>
                <div class="modal-body">
                    <form id="form-anexo" data-anexo-temp-url="{{route('sendAnexoToTemp')}}">
                        {!! csrf_field() !!}
                        <div class="col-xs-12">
                            <p><strong>Atenção:</strong> O arquivo deve ser menor que 10MB.</p>
                        </div>
                        @include('dashboard.components.form-alert')
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Descrição</label>
                                <input type="text" class="form-control" name="descricao" value=""/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Arquivo</label>
                                <input type="file" class="form-control" name="arquivo" value=""/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-success"><i class="fa fa-paperclip"></i> Anexar arquivo
                            </button>
                        </div>
                        <div class=" clearfix"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>
@stop
