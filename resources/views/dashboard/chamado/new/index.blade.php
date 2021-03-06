@extends('dashboard.layouts.master')
@section('video-ajuda')
    <li><a id="btn-ajuda" data-placement="bottom" title="Precisa de ajuda? Veja nosso vídeo explicativo sobre essa página!" href="" data-toggle="modal" data-target="#modal-video-ajuda"><span class="fa fa-youtube-play"></span>
            Ajuda</a></li>
@stop
@section('modal-video-ajuda-titulo', 'Como abrir um chamado')
@section('modal-video-ajuda-embed')
    <iframe width="560" height="315" src="https://www.youtube.com/embed/hXi6UWT9T2U" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
@stop
@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                $(this).addClass('disabled').prop('disabled', true);
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
                    $('.btn-success[type="submit"]').removeClass('disabled').prop('disabled', false);
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
@section('top-title')
    <a href="{{route('listAtendimentosToUser')}}">Atendimento</a> <i class="fa fa-angle-right"></i> Novo chamado
@stop
@section('content')
    <div class="panel">
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
                        @foreach($tiposChamado as $tipoChamado)
                            <option value="{{$tipoChamado->id}}">{{$tipoChamado->descricao}}</option>
                        @endforeach
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
            <div id="anexos" class="hidden">
                <div class="col-sm-12">
                    <h4>Anexos</h4>
                </div>
                <div class="list">

                </div>
                <div class="clearfix"></div>

            </div>
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="navigation-options">
                <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>

                <button type="submit" class="btn btn-success"><i class="fa fa-envelope"></i> Abrir chamado</button>
            </div>
        </form>
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
    @include('dashboard.modals.video-ajuda')
@stop
