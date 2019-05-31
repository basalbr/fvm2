@extends('admin.layouts.master')

@section('top-title')
    Cadastros <i class="fa fa-angle-right"></i> <a href="{{route('listCadastroAlteracao')}}">Recálculos</a> <i
            class="fa fa-angle-right"></i> Novo tipo de recálculo
@stop
@section('js')
    @parent
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=xs6j8xeombkhwcowbftixwvy24erlvylumyoad8shqc46c98"></script>
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
    <div class="tab-content">
        <form class="form" method="POST" action="" id="form-principal"
              data-validation-url="{{route('validateTipoRecalculo')}}" enctype="multipart/form-data">
            <div role="tabpanel" class="active tab-pane animated fadeIn" id="todo">
                <div class="col-xs-12">
                    <h3>Informações</h3>
                </div>
                @include('admin.components.form-alert')
                @include('admin.components.disable-auto-complete')
                {{csrf_field()}}
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Descrição *</label>
                        <input class="form-control" name="descricao" value=""/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Valor *</label>
                        <input class="form-control money-mask" name="valor" value=""/>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="navigation-options">
                <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
            </div>
        </form>
    </div>
@stop