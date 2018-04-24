@extends('admin.layouts.master')

@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#send-documentos').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal(false);
            });

            $('#finish-later').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal(true);
            });

        });

        function validateFormPrincipal(temp) {
            var formData = new FormData();
            var params = $('#form-principal').serializeArray();
            if (temp) {
                var url = $('#form-principal').data('validation-temp-url');
            } else {
                var url = $('#form-principal').data('validation-url');
            }
            $(params).each(function (index, element) {
                formData.append(element.name, element.value);
            });
            $.post({
                url: url,
                data: formData,
                contentType: false,
                processData: false
            }).done(function (data, textStatus, jqXHR) {
                if (temp) {
                    $('#form-principal').attr('action', $('#form-principal').data('temp')).submit();
                } else {
                    $('#form-principal').submit();
                }
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

@section('top-title')
    <a href="{{route('listImpostoRendaToAdmin')}}">Imposto de Renda</a> <i
            class="fa fa-angle-right"></i> Declaração de {{$ir->declarante->nome}}
@stop

@section('content')
    <!-- Nav tabs -->
    @include('admin.imposto_renda.view.components.tabs')

    <form class="form" method="POST" action="" id="form-principal">
        {{csrf_field()}}
        <input type="hidden" name="exercicio" value="{{$anoAnterior}}">
    @include('admin.components.disable-auto-complete')
    <!-- Tab panes -->
        <div class="tab-content">
            @include('admin.components.form-alert')
            <div class="clearfix"></div>
            @include('admin.imposto_renda.view.components.tab-geral')
            @include('admin.imposto_renda.view.components.tab-admin')
            <div role="tabpanel" class="tab-pane animated fadeIn" id="messages">
                <div class="col-sm-12">
                    @include('admin.components.chat.box', ['model'=>$ir])
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="navigation-options">
                <a class="btn btn-default" href="{{URL::previous()}}"><i
                            class="fa fa-angle-left"></i>
                    Voltar</a>
            </div>

        </div>
    </form>
@stop
