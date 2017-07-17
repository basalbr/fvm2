@extends('admin.layouts.master')
@section('content')
    <h1>{{$usuario->nome}}</h1>
    <hr>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#principal" aria-controls="principal" role="tab" data-toggle="tab"><i class="fa fa-home"></i>
                Informações</a>
        </li>
        <li role="presentation">
            <a href="#abertura-empresa" aria-controls="abertura-empresa" role="tab" data-toggle="tab"><i
                        class="fa fa-comments"></i>Abertura de empresas <span
                        class="badge">{{$aberturasEmpresa->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#chamados" aria-controls="chamados" role="tab" data-toggle="tab"><i class="fa fa-users"></i>Chamados
                <span class="badge">{{$chamados->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#alteracoes" aria-controls="alteracoes" role="tab" data-toggle="tab"><i
                        class="fa fa-address-card"></i>Alterações <span
                        class="badge">{{$alteracoes->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#empresas" aria-controls="empresas" role="tab" data-toggle="tab"><i class="fa fa-info"></i>Empresas
                <span class="badge">{{$empresas->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#pagamentos" aria-controls="pagamentos" role="tab" data-toggle="tab"><i class="fa fa-info"></i>Pagamentos
                <span class="badge">{{$ordensPagamento->count()}}</span></a>
        </li>

    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="principal">
            @include('admin.usuarios.view.components.principal')
        </div>
        <div role="tabpanel" class="tab-pane" id="abertura-empresa">
            @include('admin.usuarios.view.components.abertura_empresa')
        </div>
        <div role="tabpanel" class="tab-pane" id="chamados">
            @include('admin.usuarios.view.components.chamados')
        </div>
        <div role="tabpanel" class="tab-pane" id="alteracoes">
            @include('admin.usuarios.view.components.alteracoes')
        </div>
        <div role="tabpanel" class="tab-pane" id="empresas">
            @include('admin.usuarios.view.components.empresas')
        </div>
        <div role="tabpanel" class="tab-pane" id="pagamentos">
            @include('admin.usuarios.view.components.pagamentos')
        </div>
        <div class="clearfix"></div>
        <hr/>
        <div class="col-xs-12">
            <a href="{{route('listUsuariosToAdmin')}}" class="btn btn-default"><i class="fa fa-th"></i> Voltar para
                listagem</a>
        </div>
    </div>

@stop
