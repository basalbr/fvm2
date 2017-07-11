@extends('admin.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Pagamentos</h1>
        <hr>
    </div>
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.pagamentos.components.tabs')
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            @include('admin.pagamentos.components.pendentes')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
            @include('admin.pagamentos.components.historico')
        </div>
    </div>
    <div class="clearfix"></div>

@stop