@extends('dashboard.layouts.master')
@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });
        });
        function validateFormPrincipal() {
            var formData = new FormData();
            var params = $('#form-principal').serializeArray();
            $(params).each(function (index, element) {
                formData.append(element.name, element.value);
            });
            $.post({
                url: $('#form-principal').data('validation-url'),
                data: formData,
                contentType: false,
                processData: false
            }).done(function () {
                $('#form-principal').submit();
            }).fail(function (jqXHR) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError($('#form-principal'), jqXHR.responseJSON);
                } else {
                    showFormValidationError($('#form-principal'));
                }
            });
        }
    </script>
@stop
@section('top-title')
    <a href="{{route('listDemissaoToUser')}}">Demissões</a> <i class="fa fa-angle-right"></i> <a
            href="{{route('showEmpresaToUser', $funcionario->empresa->id)}}">{{$funcionario->empresa->nome_fantasia}}</a>
    <i class="fa fa-angle-right"></i> <a
            href="{{route('showFuncionarioToUser', [$funcionario->empresa->id, $funcionario->id])}}">{{$funcionario->nome_completo}}</a>
    <i class="fa fa-angle-right"></i> Solicitar Demissão
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#docs" aria-controls="docs" role="tab" data-toggle="tab"><i class="fa fa-info"></i>
                Principal</a>
        </li>

    </ul>
    <div class="tab-content">
        <form method="POST" action="" id="form-principal" data-validation-url="{{route('validateDemissao')}}">
            @include('dashboard.components.form-alert')
            @include('dashboard.components.disable-auto-complete')
            {{csrf_field()}}
            <div role="tabpanel" class="tab-pane animated fadeIn active" id="docs">
                <div class="col-sm-12">
                    <p>{{Auth::user()->nome}}, complete os campos abaixo e após isso clique em <strong>Solicitar
                            Demissão</strong> para concluir o pedido de demissão.</p>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Funcionário</label>
                        <div class="form-control">
                            <a href="{{route('showFuncionarioToUser', [$funcionario->empresa->id, $funcionario->id])}}">
                                {{$funcionario->nome_completo}}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Empresa</label>
                        <div class="form-control">
                            <a href="{{route('showEmpresaToUser', [$funcionario->empresa->id])}}">
                                {{$funcionario->empresa->nome_fantasia}} ({{$funcionario->empresa->razao_social}})
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Tipo de demissão *</label>
                        <select class="form-control" name="id_tipo_demissao">
                            <option value="1">Empresa está demitindo</option>
                            <option value="2">Funcionário solicitou demissão</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tipo de aviso prévio *</label>
                        <select class="form-control" name="id_tipo_aviso_previo">
                            <option value="1">Trabalhado</option>
                            <option value="2">Indenizado</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Data de demissão *</label>
                        <input class="form-control date-mask" name="data_demissao"/>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Observações</label>
                        <textarea name="observacoes" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="animated slideInUp navigation-options">
                <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
               <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Solicitar Demissão</button>
            </div>
        </form>
    </div>

@stop
