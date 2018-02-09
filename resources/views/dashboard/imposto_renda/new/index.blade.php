@extends('dashboard.layouts.master')

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
    <a href="{{route('listImpostoRendaToUser')}}">Imposto de Renda</a> <i
            class="fa fa-angle-right"></i> Enviar Declaração
@stop

@section('content')
    <!-- Nav tabs -->
    @include('dashboard.imposto_renda.new.components.tabs')

    <form class="form" method="POST" action="" id="form-principal"
          data-validation-url="{{route('validateImpostoRenda')}}"
          data-validation-temp-url="{{route('validateImpostoRendaTemp')}}"
          data-temp="{{route('saveIrTemp')}}">
        {{csrf_field()}}
        <input type="hidden" name="exercicio" value="{{$anoAnterior}}">
    @include('dashboard.components.disable-auto-complete')
    <!-- Tab panes -->
        <div class="tab-content">
            @include('dashboard.components.form-alert')
            <div class="clearfix"></div>
            @include('dashboard.imposto_renda.new.components.tab-geral')
            @include('dashboard.imposto_renda.new.components.tab-rendimentos')
            @include('dashboard.imposto_renda.new.components.tab-recibos')
            @include('dashboard.imposto_renda.new.components.tab-doacoes')
            @include('dashboard.imposto_renda.new.components.tab-bens')
            @include('dashboard.imposto_renda.new.components.tab-dividas')
            @include('dashboard.imposto_renda.new.components.tab-outros')
            @include('dashboard.imposto_renda.new.components.tab-dependentes')
            @include('dashboard.imposto_renda.new.components.tab-documentos-enviados')
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="navigation-options">
                <a class="btn btn-default" href="{{URL::previous()}}"><i
                            class="fa fa-angle-left"></i>
                    Voltar</a>
                <button class="btn btn-success" id="send-documentos"><span class="fa fa-send"></span> Enviar Declaração
                </button>
                <button class="btn btn-primary" type="button" id="finish-later"><span class="fa fa-history"></span>
                    Continuar Depois
                </button>
            </div>

        </div>
    </form>
@stop
@section('modals')
    @parent
    @include('dashboard.imposto_renda.new.modals.dependente')
    @include('dashboard.imposto_renda.new.modals.remove-dependente')
@stop
