@extends('dashboard.layouts.master')
<!-- Manipulação de CNAES -->
@include('dashboard.components.cnaes.search')
<!-- Manipulação de Sócios -->
@include('dashboard.components.socios.add')
@section('js')
    @parent
    <script type="text/javascript">
        var qtdeFuncionarios, qtdeProLabores, qtdeDocContabeis, qtdeDocFiscais = 0;

        $(function () {
            $('[name="qtde_funcionarios"], [name="qtde_pro_labores"],[name="qtde_doc_contabeis"],[name="qtde_doc_fiscais"]').on('blur, focus', function () {
                qtdeFuncionarios = parseInt(isNaN($('[name="qtde_funcionarios"]').val()) ? 0 : $('[name="qtde_funcionarios"]').val());
                qtdeProLabores = parseInt(isNaN($('[name="qtde_pro_labores"]').val()) ? 0 : $('[name="qtde_pro_labores"]').val());
                qtdeDocContabeis = parseInt(isNaN($('[name="qtde_doc_contabeis"]').val()) ? 0 : $('[name="qtde_doc_contabeis"]').val());
                qtdeDocFiscais = parseInt(isNaN($('[name="qtde_doc_fiscais"]').val()) ? 0 : $('[name="qtde_doc_fiscais"]').val());
                simulateMonthlyPayment(qtdeFuncionarios, qtdeProLabores, qtdeDocContabeis, qtdeDocFiscais);
            });
        });

        var simulateMonthlyPayment = function (qtdeFuncionarios, qtdeProLabores, qtdeDocContabeis, qtdeDocFiscais, currentPayment) {
            if (!currentPayment) {
                currentPayment = 0;
            }
            $.post($('.summary').data('simulator-url'), {
                "qtdeFuncionarios": qtdeFuncionarios,
                "qtdeProLabores": qtdeProLabores,
                qtdeDocContabeis: "qtdeDocContabeis",
                qtdeDocFiscais: "qtdeDocFiscais",
                currentPayment: "currentPayment"
            }).done(function (data, textStatus, jqXHR) {
                $('#monthlyPrice').text('R$'+data.monthlyPrice);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                $('#modal-cnae').find('.none').show();
            });

        };
    </script>
@stop
@section('content')
    <h1>Abrir empresa</h1>
    <hr>
    <form class="form" method="POST" action="" id="form-principal">
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
                <a href="#resumo" aria-controls="resumo" role="tab" data-toggle="tab"><i class="fa fa-list"></i>
                    Resumo</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="empresa">
                @include('dashboard.abertura_empresa.new.components.info_empresa')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="endereco">
                @include('dashboard.abertura_empresa.new.components.endereco')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="socios">
                @include('dashboard.abertura_empresa.new.components.socios')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="cnae">
                @include('dashboard.abertura_empresa.new.components.cnae')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="resumo">
                @include('dashboard.abertura_empresa.new.components.resumo')
                <div class="clearfix"></div>
            </div>
        </div>
    </form>

@stop

