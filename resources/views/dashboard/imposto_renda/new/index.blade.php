@extends('dashboard.layouts.master')

@section('top-title')
    <a href="{{route('listImpostoRendaToUser')}}">Imposto de Renda</a> <i
            class="fa fa-angle-right"></i> Enviar Declaração
@stop
@section('content')


    <!-- Nav tabs -->
    @include('dashboard.imposto_renda.new.components.tabs')

    <form class="form" method="POST" action="" id="form-principal"
          data-validation-url="{{route('validateEmpresa')}}">
    {{csrf_field()}}
    @include('dashboard.components.form-alert')
    @include('dashboard.components.disable-auto-complete')
    <!-- Tab panes -->
        <div class="tab-content">
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

                <button class="btn btn-success" id="send-documentos"><span class="fa fa-send"></span> Enviar
                    Declaração de
                    Imposto de Renda
                </button>
            </div>

        </div>
    </form>
@stop
@section('modals')
    @parent
    @include('dashboard.imposto_renda.new.modals.dependente')
@stop
