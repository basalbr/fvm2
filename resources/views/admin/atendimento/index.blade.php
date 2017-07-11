@extends('admin.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Atendimento</h1>
        <hr>
    </div>
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.atendimento.components.tabs')
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="chamados">
            @include('admin.atendimento.components.chamados')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="empresas">
            @include('admin.atendimento.components.empresas')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="abertura-empresas">
            @include('admin.atendimento.components.abertura_empresas')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="solicitacoes">
            @include('admin.atendimento.components.solicitacoes')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="apuracoes">
            @include('admin.atendimento.components.apuracoes')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="documentos-contabeis">
            @include('admin.atendimento.components.documentos_contabeis')
        </div>
    </div>
    <div class="clearfix"></div>

@stop