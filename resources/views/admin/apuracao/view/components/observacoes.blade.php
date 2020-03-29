@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            var reference, referenceId;
            $(function () {
                reference = $('#form-observacao').data('reference');
                referenceId = $('#form-observacao').data('reference-id');
                $('#form-observacao textarea').on('keypress', function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        var content = this.value;
                        var caret = getCaret(this);
                        if (event.shiftKey) {
                            this.value = content.substring(0, caret) + "\n" + content.substring(caret, content.length);
                            event.stopPropagation();
                        } else {
                            sendObservation();
                        }
                    }
                });
                $('#form-observacao button').on('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    sendObservation();
                });
            });

            function sendObservation() {
                var info = {
                    mensagem: $('#form-observacao textarea').val(),
                    referencia: reference,
                    id_referencia: referenceId
                };
                $('#form-observacao textarea').val(null);

                $.post($('#form-observacao').data('send-annotation-url'), info)
                    .done(function (data, textStatus, jqXHR) {
                        if (data.anotacao !== null) {
                            $("#form-observacao .anotacoes").prepend(data.anotacao);
                            $('#form-observacao .no-messages').hide();
                            var cnt = parseInt($('[href="#observacoes"] .badge').text());
                            cnt++;
                            $('[href="#observacoes"] .badge').text(cnt);
                        }
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        showModalValidationError(jqXHR.responseJSON)
                    });
            }
        });
    </script>
@stop
<form id="form-observacao" data-reference="observacao_apuracao" data-reference-id="{{$apuracao->empresa->id}}"
      data-send-annotation-url="{{route('sendAnnotationAjax')}}">
    <div class="form-group">
        <label>Nova observação</label>
        <textarea class="form-control" placeholder="Digite sua observação"></textarea>
        <div class="btn-block text-right">
        <small>Pressione Shift+Enter para criar uma nova linha</small>
        <button type="button" class="btn btn-success"><i class="fa fa-pencil"></i></button>
        </div>
    </div>

    <div class="anotacoes">
        @if($qtdeObservacoes > 0)
            @foreach($observacoes->reverse() as $observacao)
                <div class="anotacao animated fadeIn col-sm-12">
                    <div class="mensagem">{{$observacao->mensagem}}</div>
                    <div class="quem">{{$observacao->usuario->nome}}
                        - {{$observacao->created_at->format('d.m.Y H:i')}}</div>
                </div>
            @endforeach
        @else
            <div class="no-messages">Nenhuma observação encontrada</div>
        @endif
    </div>
    <div class="clearfix"></div>

</form>
<div class="clearfix"></div>