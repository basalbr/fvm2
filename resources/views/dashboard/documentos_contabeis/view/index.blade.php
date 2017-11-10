@extends('dashboard.layouts.master')

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
                showModalAlert('É necessário anexar pelo menos um documento. Caso não tenha documentos para enviar, clique em "Sem movimento"');
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
@section('top-title')
    <a href="{{route('listDocumentosContabeisToUser')}}">Documentos Contábeis</a> <i class="fa fa-angle-right"></i> {{$processo->empresa->nome_fantasia}} <i class="fa fa-angle-right"></i> Enviar Documentos - {{$processo->periodo->format('m/Y')}}
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab"><i
                        class="fa fa-info-circle"></i>
                Informações / Enviar documentos</a>
        </li>
        <li role="presentation">
            <a href="#mensagens" aria-controls="mensagens" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Mensagens <span
                        class="badge">{{$processo->mensagens()->where('lida','=',0)->where('from_admin','=',1)->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#anexos" aria-controls="anexos" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i>
                Documentos enviados <span class="badge"></span></a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            <p>{{Auth::user()->nome}}, nesse local é onde você vai enviar documentos como: extratos bancários, recibos e todas as despesas relacionadas à empresa {{$processo->empresa->razao_social}}, bem como comprovantes de pagamento.</p>
            <p><strong>Sempre que possível envie todos os documentos em zip.</strong></p>
            <p>Após enviar todos os documentos, clique no botão <strong>concluir</strong> que está na parte inferior da tela.</p>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Empresa</label>
                    <div class="form-control">{{$processo->empresa->nome_fantasia}}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Status</label>
                    <div class="form-control">{{$processo->getStatus()}}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Competência</label>
                    <div class="form-control">{{$processo->periodo->format('m/Y')}}</div>
                </div>
            </div>
            <div class="clearfix"></div>

            @if($processo->isPending())
                <div class="col-sm-12">
                    <hr>
                    <h3>Anexar documentos</h3>
                    <p><strong>Atenção:</strong> Os documentos anexados podem ser acessados na aba "Documentos
                        Enviados"
                        na parte superior.</p>
                    <br/>
                    <button type="button" class="btn btn-primary open-modal" data-modal="#modal-anexar-arquivo"><i
                                class="fa fa-paperclip"></i> Clique para anexar um arquivo
                    </button>

                </div>
                <div class="clearfix"></div>
            @endif

        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="mensagens">
                @include('dashboard.components.chat.box', ['model'=>$processo, 'lockUpload'=>true])
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="anexos">
            <form method="POST" action="" id="form-principal" enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('dashboard.components.form-alert')
                <div id="anexos">
                    <br/>
                    <div class="col-sm-12">
                        <p>Aqui estão os arquivos relacionados à esse processo.</p>
                    </div>
                    <div class="list">
                        @foreach($processo->anexos as $anexo)
                            <div class="col-sm-4">
                                @include('dashboard.components.anexo.withDownload', ['anexo'=>$anexo])
                            </div>
                        @endforeach
                        @foreach($processo->mensagens as $message)
                            @if($message->anexo)
                                <div class="col-sm-4">
                                    @include('dashboard.components.anexo.withDownload', ['anexo'=>$message->anexo])
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options">
            <a class="btn btn-default" href="{{URL::previous()}}"><i
                        class="fa fa-angle-left"></i>
                Voltar</a>
            @if($processo->isPending())
                <button class="btn btn-success" type="button" id="update"><i class="fa fa-check"></i> Concluir
                </button>
                <a class="btn btn-danger" href="{{route('flagDocumentosContabeisAsSemMovimento', [$processo->id])}}"><i class="fa fa-remove"></i> Sem movimento</a>
            @endif
        </div>
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
                                <label>Que tipo de documento quer enviar?</label>

                                <select class="form-control" id="descricao_arquivo">
                                    <option value="">Selecione uma opção</option>
                                    @foreach($tiposDocumentos as $tipo)
                                        <option value="{{$tipo->descricao}}">{{$tipo->descricao}}</option>
                                    @endforeach
                                    <option value="outro">Outro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12" id="descricao_div" style="display: none">
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
