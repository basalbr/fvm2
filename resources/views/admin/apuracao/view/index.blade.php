@extends('admin.layouts.master')
@include('admin.components.annotation-menu', ['model'=>$apuracao])
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

@section('top-title')
    <a href="{{route('listApuracoesToAdmin')}}">Apurações</a> <i
            class="fa fa-angle-right"></i> {{$apuracao->imposto->nome}} - {{$apuracao->competencia->format('m/Y')}}
@stop

@section('content')

    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Informações e documentos enviados</strong></div>
            <div class="panel-body">
                <ul class="nav nav-tabs nav-tabs-mini" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab">Informações</a>
                    </li>
                    <li role="presentation">
                        <a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab">Documentos <span class="badge">{{$qtdeDocumentos}}</span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
                        <table class="table table-striped table-hover">
                            <tbody>
                            <tr>
                                <th scope="row">Empresa</th>
                                <td>
                                    <a href="{{route('showEmpresaToAdmin', $apuracao->empresa->id)}}">{{$apuracao->empresa->razao_social}}
                                        ({{$apuracao->empresa->nome_fantasia}})</a></td>
                            </tr>
                            <tr>
                                <th scope="row">Usuário</th>
                                <td>
                                    <a href="{{route('showUsuarioToAdmin', $apuracao->empresa->id_usuario)}}">{{$apuracao->empresa->usuario->nome}}</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Imposto</th>
                                <td>{{$apuracao->imposto->nome}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Competência</th>
                                <td>{{$apuracao->competencia->format('m/Y')}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Código de Acesso</th>
                                <td>{{$apuracao->empresa->codigo_acesso_simples_nacional ?: 'Não informado'}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td>{!! $apuracao->getLabelStatus() !!}</td>
                            </tr>
                            <tr>
                                <th scope="row">Qtde Notas de Serviço</th>
                                <td>{{$apuracao->qtde_notas_servico ?: 'Não informado'}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Qtde Notas de Entrada</th>
                                <td>{{$apuracao->qtde_notas_entrada ?: 'Não informado'}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Qtde Notas de Saída</th>
                                <td>{{$apuracao->qtde_notas_saida ?: 'Não informado'}}</td>
                            </tr>
                            @if($apuracao->guia)
                                <tr>
                                    <th scope="row">Qtde Documentos Fiscais</th>
                                    <td>{{$apuracao->qtde_notas_saida + $apuracao->qtde_notas_entrada + $apuracao->qtde_notas_servico }}
                                        / {{$apuracao->empresa->getMensalidadeAtual()->qtde_documento_fiscal}}</td>
                                </tr>
                                <tr>
                                    <th>Guia da Apuração</th>
                                    <td>
                                        <a href="{{asset(public_path().'storage/anexos/'. $apuracao->getTable() . '/'.$apuracao->id . '/' . $apuracao->guia)}}"
                                           download>Download</a>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="documentos">
                        <table class="table table-striped table-hover">
                            @if($qtdeDocumentos > 0)
                                @foreach($apuracao->informacoes as $informacao)
                                    @if($informacao->tipo->tipo == 'anexo')
                                        <tr>
                                            <th>{{$informacao->tipo->tipo->nome}}</th>
                                            <td>
                                                {!! $informacao->getLink() !!}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach($apuracao->anexos as $anexo)
                                    <tr>
                                        <th>{{$anexo->descricao}}</th>
                                        <td>
                                            {!! $anexo->getLink() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach($apuracao->mensagens as $message)
                                    @if($message->anexo)
                                        <th>{{$message->anexo->descricao}}</th>
                                        <td>
                                            {!! $message->anexo->getLink() !!}
                                        </td>
                                    @endif
                                @endforeach
                                <tr><td colspan="2" class="text-center"><a href="{{route('downloadZipApuracao', $apuracao->id)}}" target="_blank">Baixar todos os arquivos em ZIP</a></td></tr>
                            @else
                                <tr>
                                    <td class="text-center">Nenhum documento enviado</td>
                                </tr>
                            @endif
                            <tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Mensagens</strong></div>
            <div class="panel-body" id="messages">
                @include('admin.components.chat.box2', ['model'=>$apuracao])</div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="navigation-space-tabless"></div>
    <div class="navigation-options animated slideInUp">
        <a class="btn btn-default" href="{{URL::previous()}}"><i
                    class="fa fa-angle-left"></i>
            Voltar</a>
        <button type="button" data-toggle="modal" data-target="#modal-realizar-acao" class="btn btn-primary"><i
                    class="fa fa-cogs"></i> Alterar Status / Enviar Guia
        </button>
    </div>
@stop
@section('modals')
    @parent
    @include('admin.apuracao.view.modals.realizar-acao')
@stop
