@extends('dashboard.layouts.master')
@section('content')
    <h2>Abrir empresa</h2>
    <div class="col-xs-12">
        <form class="form" method="POST" action="">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab">Informações da empresa</a>
                </li>
                <li role="presentation">
                    <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Endereço</a></li>
                <li role="presentation">
                    <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Sócios</a>
                </li>
                <li role="presentation">
                    <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Cnae</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="empresa">
                    @include('dashboard.abertura_empresa.new.components.info_empresa')
                </div>
                <div role="tabpanel" class="tab-pane" id="endereco">
                    @include('dashboard.abertura_empresa.new.components.endereco')
                </div>
                <div role="tabpanel" class="tab-pane" id="socios">
                    @include('dashboard.abertura_empresa.new.components.socios')
                </div>
                <div role="tabpanel" class="tab-pane" id="cnae">
                    @include('dashboard.abertura_empresa.new.components.cnae')
                </div>
            </div>
        </form>
    </div>
@stop