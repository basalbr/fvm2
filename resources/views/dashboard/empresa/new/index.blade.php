@extends('dashboard.layouts.master')

@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                $(this).addClass('disabled').prop('disabled', true);
                validateFormPrincipal();
            });
        });

        function checkSocioPrincipal() {
            var countSocios = 0;
            $('#form-principal').find("[name*='principal']").each(function () {
                if ($(this).val() === '1') {
                    countSocios++;
                }
            });
            if (countSocios === 1) {
                return true;
            }
            if (countSocios > 1) {
                showFormValidationError($('#form-principal'), ['A empresa deve possuir somente um sócio principal. Você cadastrou ' + countSocios]);
                return false
            }
            showFormValidationError($('#form-principal'), ['É necessário ter um sócio principal cadastrado.']);
            return false;
        }

        function checkCnaes() {
            var cnaes = $("#form-principal input[name*='cnaes']").serializeArray();
            if (cnaes.length > 0) {
                for (var i in cnaes) {
                    if (cnaes[i].value !== null) return true;
                }
            }
            showFormValidationError($('#form-principal'), ['É necessário adicionar ao menos um CNAE.']);
            return false;

        }

        function validateFormPrincipal() {
            if (checkSocioPrincipal() && checkCnaes()) {
                var formData = $('#form-principal').serializeArray();
                $.post($('#form-principal').data('validation-url'), formData)
                    .done(function (data, textStatus, jqXHR) {
                        $('#form-principal').submit();
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        $('.btn-success[type="submit"]').removeClass('disabled').prop('disabled', false);
                        if (jqXHR.status === 422) {
                            //noinspection JSUnresolvedVariable
                            showFormValidationError($('#form-principal'), jqXHR.responseJSON);
                        } else {
                            showFormValidationError($('#form-principal'));
                        }
                    });
            }

        }
    </script>
@stop
@section('top-title')
    <a href="{{route('listEmpresaToUser')}}">Empresas</a> <i class="fa fa-angle-right"></i> Migrar Empresa
@stop
@section('content')
    <form class="form" method="POST" action="" id="form-principal"
          data-validation-url="{{route('validateEmpresa')}}">
    @include('dashboard.components.form-alert')
    @include('dashboard.components.disable-auto-complete')
    {{csrf_field()}}
    <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab"><i class="fa fa-info"></i>
                    Informações da empresa</a>
            </li>
            <li role="presentation">
                <a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab"><i
                            class="fa fa-address-card"></i> Endereço</a>
            </li>
            <li role="presentation">
                <a href="#socios" aria-controls="socios" role="tab" data-toggle="tab"><i class="fa fa-users"></i> Sócios</a>
            </li>
            <li role="presentation">
                <a href="#cnae" aria-controls="cnae" role="tab" data-toggle="tab"><i class="fa fa-list"></i>
                    CNAEs</a>
            </li>
            <li role="presentation">
                <a href="#resumo" aria-controls="resumo" role="tab" data-toggle="tab"><i class="fa fa-calculator"></i>
                    Resumo</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="empresa">
                @include('dashboard.empresa.new.components.info_empresa')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="endereco">
                @include('dashboard.empresa.new.components.endereco')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="socios">
                @include('dashboard.empresa.new.components.socios', [$ufs])
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="cnae">
                @include('dashboard.empresa.new.components.cnae')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="resumo">
                @include('dashboard.empresa.new.components.resumo')
                <div class="clearfix"></div>
            </div>
        </div>
    </form>

@stop

