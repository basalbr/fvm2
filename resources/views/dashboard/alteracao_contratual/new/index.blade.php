@extends('dashboard.layouts.master')
@section('video-ajuda')
    <li><a id="btn-ajuda" data-placement="bottom" title="Precisa de ajuda? Veja nosso vídeo explicativo sobre essa página!" href="" data-toggle="modal" data-target="#modal-video-ajuda"><span class="fa fa-youtube-play"></span>
            Ajuda</a></li>
@stop
@section('modal-video-ajuda-titulo', 'Como solicitar alteração contratual')
@section('modal-video-ajuda-embed')
    <iframe width="560" height="315" src="https://www.youtube.com/embed/MhajGUZm5Kk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
@stop
@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('.jornada-option input').prop('disabled', true);
            $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });
            $("[name='id_tipo_alteracao_contratual']").on('change', function () {
                if ($(this).val() == '1') {
                    $('.salario-option').show();
                    $('.jornada-option').hide();
                    $('.salario-option input').prop('disabled', false);
                    $('.jornada-option input, .jornada-option select').prop('disabled', true);
                } else {
                    $('.salario-option').hide();
                    $('.jornada-option').show();
                    $('.salario-option input').prop('disabled', true);
                    $('.jornada-option input, .jornada-option select').prop('disabled', false);
                }
            })
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
    <a href="{{route('listAlteracaoContratualToUser', $funcionario->id)}}">Alterações Contratuais</a> <i
            class="fa fa-angle-right"></i> <a
            href="{{route('showEmpresaToUser', $funcionario->empresa->id)}}">{{$funcionario->empresa->nome_fantasia}}</a>
    <i class="fa fa-angle-right"></i> <a
            href="{{route('showFuncionarioToUser', [$funcionario->empresa->id, $funcionario->id])}}">{{$funcionario->nome_completo}}</a>
@stop
@section('content')

    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#docs" aria-controls="docs" role="tab" data-toggle="tab"><i class="fa fa-info"></i>
                Principal</a>
        </li>
    </ul>
    <div class="tab-content">
        <form method="POST" action="" id="form-principal"
              data-validation-url="{{route('validateAlteracaoContratual')}}">
            @include('dashboard.components.form-alert')
            @include('dashboard.components.disable-auto-complete')
            {{csrf_field()}}
            <div role="tabpanel" class="tab-pane animated fadeIn active" id="docs">
                <div class="col-sm-12">
                    <p>{{Auth::user()->nome}}, complete os campos abaixo e após isso clique em <strong>Solicitar
                            Alteração</strong> para concluir o pedido de alteração contratual.</p>
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
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tipo de alteração *</label>
                        <select class="form-control" name="id_tipo_alteracao_contratual">
                            @foreach($tiposAlteracoes as $tipoAlteracao)
                                <option value="{{$tipoAlteracao->id}}" {{$tipoAlteracao->id == 1 ? 'selected' : ''}}>{{$tipoAlteracao->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Data de alteração *</label>
                        <input class="form-control date-mask" name="data_alteracao"/>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Motivo *</label>
                        <textarea name="motivo" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-xs-12 salario-option">
                    <div class="form-group">
                        <label>Valor do novo salário *</label>
                        <input class="form-control money-mask" name="salario"/>
                    </div>
                </div>
                <div class="jornada-option" style="display: none">
                    <div class="col-xs-12">
                        <p>Escolha o dia do descanso semanal remunerado (D.S.R)</p>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="id_grau_instrucao">D.S.R *</label>
                            <select class="form-control" id='dsr' name='dsr'>
                                @foreach($dow as $n => $dia)
                                    <option value="{{$n}}" {{$n == $contrato->dsr ? 'selected="selected"' : ''}}>{{$dia}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <p>Digite na tabela abaixo o horário de trabalho do funcionário de acordo com o dia da
                            semana.</p>
                    </div>
                    @include('dashboard.components.horario.view', ['contrato'=>$contrato, 'horarios'=>$contrato->horarios])
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="col-xs-12 navigation-options">
                <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
                <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Solicitar Alteração</button>
            </div>
        </form>
    </div>

@stop
@section('modals')
    @parent
    @include('dashboard.modals.video-ajuda')
@stop