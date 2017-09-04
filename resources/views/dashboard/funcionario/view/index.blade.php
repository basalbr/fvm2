@extends('dashboard.layouts.master')
@section('js')
    @parent
    <script type="text/javascript"
            src="{{url(public_path().'js/dashboard/funcionario/view/index.js')}}"></script>
@stop
@section('top-title')
    <a href="{{route('listFuncionarioToUser')}}">Funcionários</a> <i class="fa fa-angle-right"></i> <a href="{{route('showEmpresaToUser', $funcionario->empresa->id)}}">{{$funcionario->empresa->nome_fantasia}}</a> <i class="fa fa-angle-right"></i> {{$funcionario->nome_completo}}
@stop
@section('content')

    <form class="form" method="POST" action="" id="form-principal"
          data-validation-url="{{route('validateFuncionario')}}"
          enctype="multipart/form-data">
    @include('dashboard.components.form-alert')
    @include('dashboard.components.disable-auto-complete')
    {{csrf_field()}}
    <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            @include('dashboard.funcionario.view.components.tabs')
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active animated fadeIn" id="pessoal">
                @include('dashboard.funcionario.view.components.pessoal')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane active animated fadeIn" id="documentos-enviados">
                @include('dashboard.funcionario.view.components.documentos_enviados')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="endereco">
                @include('dashboard.funcionario.view.components.endereco')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="documentos">
                @include('dashboard.funcionario.view.components.documentos', [$ufs])
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="sindicato">
                @include('dashboard.funcionario.view.components.sindicato')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="contrato">
                @include('dashboard.funcionario.view.components.contrato')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="horario">
                @include('dashboard.funcionario.view.components.horario')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="dependentes">
                @include('dashboard.funcionario.view.components.dependentes')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="deficiencias">
                @include('dashboard.funcionario.view.components.deficiencias')
                <div class="clearfix"></div>
            </div>
            <div class="navigation-space"></div>
            <div class="col-xs-12 navigation-options">
                <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
                @if($funcionario->status == 'ativo')
                    <a class="btn btn-danger"
                       href="{{route('newDemissao', [$funcionario->id])}}">
                        <i class="fa fa-user-times"></i> Solicitar demissão
                    </a>
                    <a class="btn btn-warning"
                       href="{{route('listAlteracaoContratualToUser', [$funcionario->id])}}">
                        <i class="fa fa-edit"></i> Alteração contratual
                    </a>
                @endif
            </div>
        </div>
    </form>
@stop

@section('modals')
    @parent
    @include('dashboard.components.dependentes.view', ['dependentes' => $funcionario->dependentes])
@stop
