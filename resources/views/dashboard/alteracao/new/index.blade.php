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
            var shouldStop = false;
            var errors = [];
            $('[type="file"]').each(function () {
                    if ($(this).data('obrigatorio')) {
                        if ($(this)[0].files[0] === undefined) {
                            errors[$(this).attr('name')] = 'O campo ' + $(this).parent().find('label').text() + ' é obrigatório.';
                            shouldStop = true;
                        }
                    }
                    if ($(this)[0].files[0] !== undefined) {
                        if ($(this)[0].files[0].size > 10485760) {
                            errors[$(this).attr('name')] = $(this).parent().find('label').text() + ' não pode ser maior que 10MB.';
                            shouldStop = true;
                        }
                    }
                    formData.append($(this).attr('name'), $(this)[0].files[0]);
                }
            );
            $('[type="text"], textarea').each(function () {
                if ($(this).data('obrigatorio') && (!$(this).val() || $(this).val() === '' || $(this).val() === undefined || $(this).val() == null)) {
                    errors[$(this).attr('name')] = 'O campo ' + $(this).parent().find('label').text() + ' é obrigatório.';
                    shouldStop = true;
                }
            });
            if (shouldStop) {
                showFormValidationError($('#form-principal'), errors);
                return false;
            }
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
    <a href="{{route('chooseEmpresaSolicitacaoAlteracao')}}">Alterações</a> <i
            class="fa fa-angle-right"></i> {{$empresa->razao_social}}
@stop
@section('content')
    <div class="panel">
        <div class="col-sm-12">
            <h3>Solicitar alteração para {{$empresa->razao_social}}</h3>
            <p><strong>Preencha os campos abaixo</strong> com as informações solicitadas e clique no botão "Enviar
                solicitação" para iniciarmos o processo.</p>
            <p>Campos com <strong>* são obrigatórios.</strong></p>
            <hr>
        </div>
        <div class="clearfix"></div>
        <form class="form" method="POST" action="{{route('saveSolicitacaoAlteracao', $empresa->id)}}"
              id="form-principal"
              data-validation-url="{{route('validateAlteracao')}}" enctype="multipart/form-data">
            @include('dashboard.components.form-alert')
            <div class="clearfix"></div>
            @include('dashboard.components.disable-auto-complete')
            {!! csrf_field() !!}

            @foreach($tipos as $tipoAlteracao)
                <input type="hidden" name="tipos[]" value="{{$tipoAlteracao->id}}">
                <p class="alert-info alert" style="display: block"><strong>{{$tipoAlteracao->descricao}}</strong></p>
                <div class="clearfix"></div>
                @foreach($tipoAlteracao->getCamposAtivos() as $campo)
                    @if($campo->tipo == 'string')
                        <div class="col-sm-12">
                            <div class='form-group'>
                                <label>{{$campo->nome}} {{$campo->obrigatorio ? '*':''}}</label>
                                <input type='text' class='form-control' name='campos[{{$campo->id}}]'
                                       {{$campo->obrigatorio ? 'data-obrigatorio="true"':''}}
                                       placeholder="{{$campo->descricao}}"/>
                            </div>
                        </div>
                    @elseif($campo->tipo == 'textarea')
                        <div class="col-sm-12">
                            <div class='form-group'>
                                <label>{{$campo->nome}} {{$campo->obrigatorio ? '*':''}}</label>
                                <textarea name='campos[{{$campo->id}}]' class='form-control'
                                          {{$campo->obrigatorio ? 'data-obrigatorio="true"':''}}
                                          placeholder="{{$campo->descricao}}"></textarea>
                            </div>
                        </div>
                    @elseif($campo->tipo == 'file')
                        <div class="col-sm-12">
                            <div class='form-group'>
                                <label>{{$campo->nome}} {{$campo->obrigatorio ? '*':''}}</label>
                                <input type='file' class='form-control' value=""
                                       name='anexos[{{$campo->id}}]' {{$campo->obrigatorio ? 'data-obrigatorio="true"':''}}/>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="clearfix"></div>
            @endforeach

            <div class="col-sm-12">
                <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Enviar solicitação</button>
            </div>
        </form>
        <div class="clearfix"></div>
        <br/>
    </div>
@stop