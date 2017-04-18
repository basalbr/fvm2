@extends('dashboard.layouts.master')
@section('content')
    <h1>Abrir empresa</h1>
    <hr>
    <form class="form" method="POST" action="">
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
        </div>
    </form>

@stop
@section('modals')
    @include('dashboard.abertura_empresa.new.modals.adicionar-socio')
@stop