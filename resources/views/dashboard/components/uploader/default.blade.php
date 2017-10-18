@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#file-upload-form button').on('click', function (e) {
                e.preventDefault();
                $(this).addClass('disabled').prop('disabled', true).html('<i class="fa fa-hourglass-1"></i> Enviando, aguarde...');
                uploadFile($('#file-upload-form [type="file"]'));
            });
        });

        function uploadFile(elem) {
            if (validateFile(elem)) {
                var formData = new FormData();
                formData.append('arquivo', elem[0].files[0]);
                formData.append('descricao', $('#file-upload-form [name="descricao"]').val());
                formData.append('referencia', $('#file-upload-form [name="referencia"]').val());
                formData.append('id_referencia', $('#file-upload-form [name="id_referencia"]').val());
                $.post({
                    url: $('#file-upload-form').data('upload-url'),
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function (data, textStatus, jqXHR) {
                    addRow(data.description, data.date, data.filepath);
                    showModalAlert('Arquivo enviado com sucesso!')
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
            }
        }

        function clearUploadForm(){
            $('#file-upload-form input[type="text"], #file-upload-form input[type="file"]').val(null);
        }

        function addRow(description, date, filepath) {
            $('#list-files').find('.none').hide();
            $('#list-files').prepend('<tr class="animated slideInLeft"><td>' + description + '</td><td>' + date + '</td><td><a href="' + filepath + '" class="btn btn-success" download><i class="fa-download fa"></i> Download</a></td></tr>')
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
<div class="col-xs-12">
    <div class="form-inline" id="file-upload-form" data-upload-url="{{route('uploadFile')}}">
        @include('admin.components.disable-auto-complete')
        <input type="hidden" name="id_referencia" value="{{$idReferencia}}">
        <input type="hidden" name="referencia" value="{{$referencia}}">
        <div class="form-group">
            <label>Descrição</label>
            <input name="descricao" style="width: 300px" class="form-control" value=""/>
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
            <th>Enviado em</th>
            <th></th>
        </tr>

        </thead>
        <tbody id="list-files">
        @if(count($anexos))
            @foreach($anexos as $anexo)
                <tr>
                    <td>{{$anexo->descricao}}</td>
                    <td>{{$anexo->created_at->format('d/m/Y')}}</td>
                    <td>
                        <a download class="btn btn-success"
                           href="{{asset(public_path().'storage/anexos/'. $anexo->referencia . '/'.$anexo->id_referencia . '/' . $anexo->arquivo)}}"><i
                                    class="fa fa-download"></i> Download</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" class="none">Nenhum arquivo encontrado</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
