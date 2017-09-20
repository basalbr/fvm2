@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            var reference, referenceId;
            $(function () {
                reference = $('#form-anotacao').data('reference');
                referenceId = $('#form-anotacao').data('reference-id');
                $('#form-anotacao textarea').on('keypress', function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        var content = this.value;
                        var caret = getCaret(this);
                        if (event.shiftKey) {
                            this.value = content.substring(0, caret) + "\n" + content.substring(caret, content.length);
                            event.stopPropagation();
                        } else {
                            sendAnnotation();
                        }
                    }
                });
                $('#form-anotacao button').on('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    sendAnnotation();
                });
            });

            function sendAnnotation() {
                var info = {
                    mensagem: $('#form-anotacao textarea').val(),
                    referencia: reference,
                    id_referencia: referenceId
                };
                $('#form-anotacao textarea').val(null);

                $.post($('#form-anotacao').data('send-annotation-url'), info)
                    .done(function (data, textStatus, jqXHR) {
                        if (data.anotacao !== null) {
                            $("#form-anotacao .anotacoes").prepend(data.anotacao);
                            $('#form-anotacao .no-messages').hide();
                        }
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        showModalValidationError(jqXHR.responseJSON)
                    });
            }

        });
    </script>
@stop
<div class="modal animated fadeInDown" id="modal-annotation" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Atenção</h3>
            </div>
            <div class="modal-body">
                <form id="form-anotacao" data-reference="{{$model->getTable()}}" data-reference-id="{{$model->id}}" data-send-annotation-url="{{route('sendAnnotationAjax')}}">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Anotação</label>
                            <textarea class="form-control" placeholder="Digite sua anotação"></textarea>
                            <small>Pressione Shift+Enter para criar uma nova linha</small>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-success"><i class="fa fa-pencil"></i> Anotar</button>
                    </div>
                    <div class="col-xs-12">
                        <div class="anotacoes">
                            @include('admin.components.anotacoes.anotacoes', ['anotacoes'=>$model->anotacoes])
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar</button>
            </div>
        </div>
    </div>
</div>
