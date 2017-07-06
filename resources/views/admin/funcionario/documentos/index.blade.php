@extends('dashboard.layouts.master')
@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#modal-enviar-documento form button').on('click', function (e) {
                e.preventDefault();
                validateForm();
            });
        });

        function validateForm() {
            var formData = new FormData();
            if ($('#documento-anexo').val() !== '' && $('#documento-anexo').val() !== null && $('#documento-anexo').val() !== undefined) {
                formData.append('documento', $('#documento-anexo')[0].files[0])
            }
            var params = $('#modal-enviar-documento form').serializeArray();
            $(params).each(function (index, element) {
                formData.append(element.name, element.value);
            });
            $.post({
                url: $('#modal-enviar-documento form').data('validation-url'),
                data: formData,
                contentType: false,
                processData: false
            }).done(function (data, textStatus, jqXHR) {
                $('#modal-enviar-documento form').submit();
            }).fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError($('#modal-enviar-documento form'), jqXHR.responseJSON);
                } else {
                    showFormValidationError($('#modal-enviar-documento form'));
                }
            });
        }
    </script>
@stop
@section('content')
    <div class="col-xs-12">
        <h1>Documentos de {{$funcionario->nome_completo}}</h1>
        <p>Clique em um dos documentos abaixo para fazer download.</p>
        <hr>
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12">
        <div class="list-group">
            <button type="button" class="btn btn-primary open-modal" data-modal="#modal-enviar-documento"><span
                        class="fa fa-paperclip"></span> Enviar novo documento
            </button>
            <a href="{{route('listFuncionarioToUser')}}" class="btn btn-success"><span class="fa fa-th"></span> Listar funcionários
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="panel">
        @if($documentos->count())
            @foreach($documentos as $documento)
                <div class="col-lg-4 col-sm-6">
                    <div class="panel">
                        <a download target="_blank"
                           href="{{asset(public_path().'storage/funcionarios/'. $funcionario->id . '/documentos/' . $documento->documento)}}">
                            <div class="items">
                                <div class="col-xs-12">
                                    <i class="fa item-icon fa-paperclip text-success"></i>
                                    <div class="item-value">{{$documento->descricao}}</div>
                                    <div class="item-description">Enviado
                                        em {{$documento->created_at->format('d/m/Y')}}</div>
                                </div>
                            </div>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-xs-12">
                <h5>Não encontramos nenhum funcionário em nosso sistema</h5>
            </div>
            <div class="clearfix"></div>
        @endif
    </div>

@stop
@section('modals')
    @parent
    <div class="modal animated fadeInDown" id="modal-enviar-documento" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Enviar documento</h3>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        <p>Para enviar um documento complete as informações abaixo e clique em enviar:</p>
                    </div>
                    <form data-validation-url="{{route('validateDocumentoFuncionario')}}" method="POST" action=""
                          enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @include('dashboard.components.form-alert')
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="descricao">Tipo de documento</label>
                                <select class="form-control" name="nome">
                                    <option value="">Selecione uma opção</option>
                                    <option value="exame_admissional">Exame admissional</option>
                                    <option value="outros">Outros</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <input type="text" class="form-control" name="descricao"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="documento">Documento</label>
                                <input id="documento-anexo" type="file" class="form-control" name="documento"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Enviar documento
                            </button>
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
@stop
