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
                $(this).find('.alert').css('display', '').empty();

                $(this).find('form')[0].reset();
            });

            $('#anexos').on('click', '.remove', function () {
                showRemoveAnexoModal($(this).parent().parent());
            });

            $('#modal-remover-arquivo .btn-danger').on('click', function () {
                removeAnexo();
            });

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
    <h1>{{$alteracao->tipo->descricao}}</h1>
    <hr>
    <div class="panel">
        @if($alteracao->pagamento->isPending())
            <div class="col-sm-12">
                <div class="alert alert-warning" style="display: block;">O pagamento dessa solicitação está com o
                    status {{$alteracao->pagamento->status}}, é necessário realizar o pagamento para que possamos dar
                    início ao processo.<br/><a href='{{$alteracao->pagamento->getBotaoPagamento()}}'>Clique aqui para
                        pagar.</a></div>
            </div>
        @endif
        <div class="col-sm-12">
            <div class="col-sm-12">
                <h3>Informações</h3>
            </div>
            <div class="list">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Valor</label>
                        <div class="form-control">{{$alteracao->pagamento->formattedValue()}}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Status do processo</label>
                        <div class="form-control">{{$alteracao->status}}</div>
                    </div>
                </div>
                @if(count($alteracao->informacoes))
                    @foreach($alteracao->informacoes as $informacao)
                        @if($informacao->campo->tipo != 'file')
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{$informacao->campo->nome}}</label>
                                    <div class="form-control">{{$informacao->valor}}</div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="clearfix"></div>
            <hr>
        </div>
        <div class="col-sm-12">
            @include('dashboard.components.chat.box', ['model'=>$alteracao])
            <div class="clearfix"></div>
            <hr>
        </div>
        <div class="col-sm-12">
            <div id="anexos">
                <div class="col-sm-12">
                    <h3>Anexos</h3>
                    <p>Aqui estão os arquivos relacionados à esse processo.</p>
                </div>
                <div class="list">
                    @if(count($alteracao->informacoes))
                        @foreach($alteracao->informacoes as $anexo)
                            @if($anexo->campo->tipo == 'file')
                                <div class="col-sm-4">
                                    @include('dashboard.components.anexo.withDownload', ['anexo'=>$anexo])
                                </div>
                            @endif
                        @endforeach
                    @endif
                    @foreach($alteracao->mensagens as $message)
                        @if($message->anexo)
                            <div class="col-sm-4">
                                @include('dashboard.components.anexo.withDownload', ['anexo'=>$message->anexo])
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-sm-12">
            <a class="btn btn-default" href="{{route('listSolicitacoesAlteracaoToUser')}}"><i
                        class="fa fa-angle-left"></i>
                Voltar para solicitações</a>
        </div>
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
