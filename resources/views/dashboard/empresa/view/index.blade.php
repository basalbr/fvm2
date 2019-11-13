@extends('dashboard.layouts.master')
@section('top-title')
    <a href="{{route('listEmpresaToUser')}}">{{$empresa->status != 'aprovado' ? 'Migração' : 'Empresas'}}</a> <i class="fa fa-angle-right"></i> {{$empresa->razao_social}}
    <span class="hidden-xs">({{$empresa->nome_fantasia}})</span>
@stop
@section('js')
    @parent
    <script type="text/javascript">
        var anexoKey = 0;

        $(function () {

            $('#form-principal').on('click', '.btn-primary', function (e) {
                e.preventDefault();
                $(this).parent().find('input').click();
            });

            $('#form-principal input').on('change', function () {
                if (validateAnexo($(this))) {
                    sendAnexo($(this));
                }
            });

        });

        function validateAnexo(elem) {
            if (elem.val() !== '' &&
                elem.val() &&
                elem.val() !== undefined) {
                if ((elem[0].files[0].size / 1024) > 10240) {
                    showModalAlert('O arquivo não pode ser maior que 10MB.');
                    return false;
                }
                return true;
            } else {
                showModalAlert('É necessário escolher um arquivo para envio.');
                return false;
            }
        }

        function sendAnexo(elem) {
            elem.parent().find('.btn-primary').addClass('disabled').prop('disabled', true).html('<i class="fa fa-hourglass-1"></i> Enviando, aguarde...');
            var form = new FormData;
            form.append('arquivo', elem[0].files[0]);
            form.append('descricao', elem.data('name'));
            form.append('id_referencia', $('#referencia_id').val());
            form.append('referencia', 'empresa');
            $.post({
                url: elem.data('upload-url'),
                data: form,
                contentType: false,
                processData: false
            }).done(function (data) {
                elem.parent().find('.btn-primary, .btn-default').remove();
                elem.parent().prepend('<a class="btn btn-success" href="' + data.filepath + '" download target="_blank"><i class="fa fa-download"></i> Download</a>');
                showModalSuccess('Arquivo enviado com sucesso');
            }).fail(function (jqXHR) {
                elem.parent().find('.btn-primary').removeClass('disabled').prop('disabled', false).html('<i class="fa fa-upload"></i> Enviar arquivo');
                showModalAlert('Ocorreu um erro ao enviar o arquivo, tente novamente. Se o problema persistir nos informe através da opção "Atendimento" para que possamos investigar.');
            });
        }
    </script>
@stop
@section('content')
    <div class="col-sm-6">
        @if($empresa->hasPendencias())
            <div class="panel panel-danger pulse animated">
                <div class="panel-heading"><strong>Pendências</strong> <span
                            class="badge pull-right">{{count($empresa->getPendencias())}}</span></div>
                <div class="panel-body">
                    @include('dashboard.empresa.view.components.pendencias')
                </div>
            </div>
        @endif
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Informações e documentos enviados</strong></div>
            <div class="panel-body">
                <ul class="nav nav-tabs nav-tabs-mini" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#identificacao" aria-controls="identificacao" role="tab"
                           data-toggle="tab">Identificação</a>
                    </li>
                    <li role="presentation">
                        <a href="#mensalidade" aria-controls="mensalidade" role="tab" data-toggle="tab">Mensalidade</a>
                    </li>
                    <li role="presentation">
                        <a href="#atividades" aria-controls="atividades" role="tab" data-toggle="tab">Atividades</a>
                    </li>
                    <li role="presentation">
                        <a href="#socios" aria-controls="socios" role="tab" data-toggle="tab">Sócios</a>
                    </li>
                    <li role="presentation">
                        <a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab">Documentos <span
                                    class="badge">{{$qtdeDocumentos}}</span></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active animated fadeIn" id="identificacao">
                        @include('dashboard.empresa.view.components.info_empresa')
                    </div>
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="atividades">
                        @include('dashboard.empresa.view.components.cnae')
                    </div>
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="mensalidade">
                        @include('dashboard.empresa.view.components.mensalidade')
                    </div>
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="socios">
                        @include('dashboard.empresa.view.components.socios')
                    </div>
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="documentos">
                        @include('dashboard.empresa.view.components.docs')
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Mensagens</strong></div>
            <div class="panel-body" id="messages">
                @include('admin.components.chat.box2', ['model'=>$empresa])</div>
        </div>
    </div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
    </div>
    <input type="hidden" value="{{$empresa->id}}" id="referencia_id" />
@stop
@section('modals')
    @parent
    @include('dashboard.components.socios.view', ['socios' => $empresa->socios])
@stop