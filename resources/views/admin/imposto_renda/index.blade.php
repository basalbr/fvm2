@extends('admin.layouts.master')
@section('top-title')
    Imposto de Renda
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.imposto_renda.components.tabs')
    </ul>
    <div class="tab-content">
        @include('admin.imposto_renda.components.pendentes')
        @include('admin.imposto_renda.components.concluidos')


        <div class="clearfix"></div>
    </div>


@stop
