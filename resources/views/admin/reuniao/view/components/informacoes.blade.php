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

<div class="col-sm-6">
    <div class="form-group">
        <label>Usuário</label>
        <div class="form-control"><a
                    href="{{route('showUsuarioToAdmin', $recalculo->usuario->id)}}">{{$recalculo->usuario->nome}}</a>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label>Tipo</label>
        <div class="form-control">{{$recalculo->tipo->descricao}}</div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label>Status</label>
        <div class="form-control">{{$recalculo->getStatus()}}</div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label>Aberto em</label>
        <div class="form-control">{{$recalculo->created_at->format('m/Y')}}</div>
    </div>
</div>
<div class="col-sm-12">
    <div class="form-group">
        <label>Descrição</label>
        <div class="form-control">{{$recalculo->descricao}}</div>
    </div>
</div>
<div class="clearfix"></div>
<hr>
<div class="col-sm-12">
    <h3>Status e envio de guia</h3>
</div>
<form id="form-principal" method="POST" action="" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div class="col-sm-12">
        <div class="form-group">
            <label>Status da apuração</label>
            <select name="status" class="form-control">
                <option {{$recalculo->status == 'novo' ? 'selected' : ''}} value="novo">Novo
                </option>
                <option {{$recalculo->status == 'cancelado' ? 'selected' : ''}} value="cancelado">Cancelado
                </option>
                <option {{$recalculo->status == 'concluido' ? 'selected' : ''}} value="concluido">Concluído
                </option>
            </select>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <div class="form-control">
                <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                    Anexar guia
                </button>
            </div>
            <input data-validation-url="{{route('validateGuia')}}"
                   data-upload-url="{{route('sendAnexoToTemp')}}" class="hidden upload-informacao-extra"
                   type='file' value=""/>
        </div>
    </div>
    <div class="col-sm-12">
        <button class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
    </div>
</form>
<div class="clearfix"></div>