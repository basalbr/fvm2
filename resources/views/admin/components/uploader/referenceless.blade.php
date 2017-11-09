@section('js')
    @parent
    <script type="text/javascript">
        var fileId = 0;
        $(function () {
            $('#file-upload-form button').on('click', function (e) {
                e.preventDefault();
                $(this).addClass('disabled').prop('disabled', true).html('<i class="fa fa-hourglass-1"></i> Enviando, aguarde...');
                uploadFile($('#file-upload-form [type="file"]'));
            });

            $('#list-files').on('click','.btn-danger', function (e) {
                e.preventDefault();
                removeRow($(this));
            })
        });

        function uploadFile(elem) {
            if (validateFile(elem)) {
                var formData = new FormData();
                formData.append('arquivo', elem[0].files[0]);
                formData.append('descricao', $('#file-upload-form [name="descr"]').val());
                $.post({
                    url: $('#file-upload-form').data('upload-url'),
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function (data, textStatus, jqXHR) {
                    addRow(data.description, data.file);
                    showModalSuccess('Arquivo enviado com sucesso!')
                    clearUploadForm();
                    $('#file-upload-form button').removeClass('disabled').prop('disabled', false).html('<i class="fa fa-upload"></i> Enviar arquivo');

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
                    $('#file-upload-form button').removeClass('disabled').prop('disabled', false).html('<i class="fa fa-upload"></i> Enviar arquivo');

                });
            }else{
                $('#file-upload-form button').removeClass('disabled').prop('disabled', false).html('<i class="fa fa-upload"></i> Enviar arquivo');
            }
        }

        function clearUploadForm() {
            $('#file-upload-form input[type="text"], #file-upload-form input[type="file"]').val(null);
        }

        function addRow(description, filename) {
            $('#form-principal').append('<input type="hidden" name="anexos[' + fileId + '][descricao]" value="' + description + '"/>');
            $('#form-principal').append('<input type="hidden" name="anexos[' + fileId + '][arquivo]" value="' + filename + '"/>');
            $('#list-files').find('.none').hide();
            $('#list-files').prepend('<tr class="animated slideInLeft"><td>' + description + '</td><td><a href="" data-id="' + fileId + '" class="btn btn-danger"><i class="fa-remove fa"></i> Excluir</a></td></tr>')
            fileId++;
        }

        function removeRow(elem) {
            elem.parent().parent().remove();
            $('[name^="anexos[' + elem.data('id') + ']"]').remove();
            if($('#list-files tr').length < 2){
                $('#list-files .none').show();
            }
            showModalSuccess('Arquivo removido com sucesso.');
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
    </script>
@stop
@if(!isset($lock) || !$lock )
    <div class="col-xs-12"><p>Complete os campos abaixo e clique em "Enviar arquivo" para enviar o arquivo</p></div>
    <div class="clearfix"></div>
    <div class="col-xs-12">
        <div class="form-inline" id="file-upload-form" data-upload-url="{{route('uploadTempFile')}}">
            @include('admin.components.disable-auto-complete')
            <div class="form-group">
                <label>Descrição do arquivo</label>
                <input type="text" name="descr" style="width: 300px" class="form-control" value=""/>
            </div>
            <div class="form-group">
                <label>Selecione um arquivo</label>
                <input type="file" name="arquivo" class="form-control" value=""/>
            </div>
            <div class="clearfix"></div>
            <button type="button" class="btn btn-primary"><i class="fa fa-upload"></i> Enviar arquivo</button>
        </div>
    </div>
    <div class="clearfix"></div>
    <hr>
@endif
<div class="col-xs-12">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Descrição</th>
            <th></th>
        </tr>

        </thead>
        <tbody id="list-files">

        <tr>
            <td colspan="2" class="none">Nenhum arquivo encontrado</td>
        </tr>
        </tbody>
    </table>
</div>
