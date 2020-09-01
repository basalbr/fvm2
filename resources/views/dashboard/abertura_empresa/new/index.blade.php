@extends('dashboard.layouts.master')

@section('js')
    @parent
    <script type="text/javascript"
            src="{{url(public_path().'js/dashboard/abertura_empresa/new/index.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
            $('[name="nome_empresarial1"]').on('change', function () {
                $('#razao_social_contrato').text(($(this).val()));
            })
            $('[name="cnpj"]').on('change', function () {
                $('#cnpj_contrato').text(($(this).val()));
            })
            $('[name="mensalidade[qtde_funcionario]"]').on('change', function () {
                $('.funcionarios_contrato').text(($(this).val()));
            })
            $('[name="mensalidade[qtde_documento_fiscal]"]').on('change', function () {
                $('.docs_fiscais_contrato').text(($(this).val()));
            })
        });
    </script>
@stop
@section('top-title')
    <a href="{{route('listAberturaEmpresaToUser')}}">Abertura de empresa</a> <i class="fa fa-angle-right"></i> Nova
@stop
@section('content')

    <form class="form" method="POST" action="" id="form-principal"
          data-validation-url="{{route('validateAberturaEmpresa')}}">
    @include('dashboard.components.form-alert')
    @include('dashboard.components.disable-auto-complete')
    {{csrf_field()}}
    <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab"><i class="fa fa-info"></i><span
                            class="tab-text"> Info.</span></a>
            </li>
            <li role="presentation">
                <a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab"><i
                            class="fa fa-address-card"></i><span class="tab-text"> Endereço</span></a>
            </li>
            <li role="presentation">
                <a href="#socios" aria-controls="socios" role="tab" data-toggle="tab"><i class="fa fa-users"></i><span
                            class="tab-text"> Sócios</span></a>
            </li>
            <li role="presentation">
                <a href="#cnae" aria-controls="cnae" role="tab" data-toggle="tab"><i class="fa fa-list"></i><span
                            class="tab-text"> CNAEs</span></a>
            </li>
            <li role="presentation">
                <a href="#resumo" aria-controls="resumo" role="tab" data-toggle="tab"><i
                            class="fa fa-calculator"></i><span class="tab-text"> Resumo</span></a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active fadeIn animated" id="empresa">
                @include('dashboard.abertura_empresa.new.components.info_empresa')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane fadeIn animated" id="endereco">
                @include('dashboard.abertura_empresa.new.components.endereco')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane fadeIn animated" id="socios">
                @include('dashboard.abertura_empresa.new.components.socios', [$ufs])
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane fadeIn animated" id="cnae">
                @include('dashboard.abertura_empresa.new.components.cnae')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane fadeIn animated" id="resumo">
                @include('dashboard.abertura_empresa.new.components.resumo')
                <div class="clearfix"></div>
            </div>
        </div>
    </form>

@stop

