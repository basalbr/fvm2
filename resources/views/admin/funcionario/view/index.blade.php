@extends('admin.layouts.master')
@section('js')
    @parent
    <script type="text/javascript"
            src="{{url(public_path().'js/admin/funcionario/view/index.js')}}"></script>
@stop
@section('top-title')
    <a href="{{route('listFuncionarioToAdmin')}}">Funcionários</a> <i class="fa fa-angle-right"></i> <a href="{{route('showEmpresaToAdmin', $funcionario->empresa->id)}}">{{$funcionario->empresa->nome_fantasia}}</a> <i class="fa fa-angle-right"></i> {{$funcionario->nome_completo}}
@stop
@section('content')
    <form class="form" method="POST" action="" id="form-principal"
          data-validation-url="{{route('validateFuncionario')}}"
          enctype="multipart/form-data">
    @include('admin.components.form-alert')
    @include('admin.components.disable-auto-complete')
    {{csrf_field()}}
    <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            @include('admin.funcionario.view.components.tabs')
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active animated fadeIn" id="principal">
                @include('admin.funcionario.view.components.principal')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="messages">
                <div class="col-xs-12">
                    @include('admin.components.chat.box', ['model'=>$funcionario])
                </div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="documentos-enviados">
                @include('admin.funcionario.view.components.documentos_enviados')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="pessoal">
                @include('admin.funcionario.view.components.pessoal')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="endereco">
                @include('admin.funcionario.view.components.endereco')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="documentos">
                @include('admin.funcionario.view.components.documentos', [$ufs])
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="sindicato">
                @include('admin.funcionario.view.components.sindicato')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="contrato">
                @include('admin.funcionario.view.components.contrato')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="horario">
                @include('admin.funcionario.view.components.horario')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="dependentes">
                @include('admin.funcionario.view.components.dependentes')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="deficiencias">
                @include('admin.funcionario.view.components.deficiencias')
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="navigation-options animated slideInUp">
                <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
                @if($funcionario->status == 'pendente')
                    <a class="btn btn-success"
                       href="{{route('activateFuncionario', [$empresa->id, $funcionario->id])}}">
                        <i class="fa fa-check"></i> Ativar funcionário
                    </a>
                @endif
                @if($funcionario->status == 'ativo')
                    <a class="btn btn-danger"
                       href="{{route('listDocumentosFuncionarioToUser', [$empresa->id, $funcionario->id])}}">
                        <i class="fa fa-check"></i> Demitir funcionário
                    </a>

                @endif
            </div>
        </div>
    </form>
@stop
@section('modals')
    @parent
    @include('admin.components.dependentes.view', ['dependentes' => $funcionario->dependentes])
@stop
