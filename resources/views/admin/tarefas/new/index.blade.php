@extends('admin.layouts.master')

@section('top-title')
    <a href="{{route('listTarefasToAdmin')}}">Tarefas</a> <i
            class="fa fa-angle-right"></i> Nova tarefa
@stop
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{url(public_path().'vendor/css/bootstrap-datepicker3.min.css')}}"/>
@stop
@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'vendor/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('[name="data"]').datepicker({
                'todayHighlight': true,
                'autoclose' : true,
                'format': 'dd/mm/yyyy'
            });

            $('#send-form').on('click', function (e) {
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
            }).done(function (data, textStatus, jqXHR) {
                $('#form-principal').submit();
            }).fail(function (jqXHR, textStatus, errorThrown) {
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
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading"><strong>Nova Tarefa</strong></div>
        <div class="panel-body">
            <form id="form-principal" method="POST" data-validation-url="{{route('validateTarefa')}}"
                  enctype="multipart/form-data" autocomplete="off">
                @include('admin.components.form-alert')
                @include('admin.components.disable-auto-complete')
                {{csrf_field()}}
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Assunto</label>
                        <input class="form-control" name="assunto" value=""/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Data de expectativa de conclusão</label>
                        <input class="form-control" name="data" value="" autocomplete="off"/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Hora de expectativa de conclusão</label>
                        <input class="form-control time-mask" name="hora" value=""/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Responsável</label>
                        <select name="responsavel" class="form-control">
                            @foreach($funcionarios as $funcionario)
                                <option value="{{$funcionario->id}}">{{$funcionario->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Mensagem</label>
                        <textarea class="form-control" name="mensagem">{{request()->input('url') ? request()->input('url') : ''}}</textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
        <button id="send-form" type="button" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
    </div>
@stop