@extends('dashboard.layouts.master')
@section('top-title')
    Imposto de Renda
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        @include('dashboard.imposto_renda.components.tabs')
    </ul>
    <div class="tab-content">
        @include('dashboard.imposto_renda.components.pendentes')
        @include('dashboard.imposto_renda.components.concluidos')


        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options">
            <a href="{{route('newImpostoRenda')}}" class="btn btn-primary"><span
                        class="fa fa-paw"></span> Declarar Imposto de Renda</a>
        </div>
    </div>


@stop
@section('modals')
    @parent
    @include('dashboard.imposto_renda.modals.new')
@stop
