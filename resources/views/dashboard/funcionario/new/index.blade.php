@extends('dashboard.layouts.master')
@section('js')
    @parent
    <script type="text/javascript"
            src="{{url(public_path().'js/dashboard/funcionario/new/index.js')}}"></script>
@stop
@section('top-title')
    <a href="{{route('listFuncionarioToUser')}}">Funcionários</a> <i class="fa fa-angle-right"></i> <a href="{{route('showEmpresaToUser', $empresa->id)}}">{{$empresa->nome_fantasia}}</a> <i class="fa fa-angle-right"></i> Cadastrar Funcionário
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
            <li role="presentation" class="active">
                <a href="#pessoal" aria-controls="pessoal" role="tab" data-toggle="tab"><i class="fa fa-id-badge"></i>
                    Pessoal</a>
            </li>
            <li role="presentation">
                <a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab"><i
                            class="fa fa-address-card"></i> Endereço</a>
            </li>
            <li role="presentation">
                <a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab"><i
                            class="fa fa-files-o"></i> Documentos</a>
            </li>
            <li role="presentation">
                <a href="#deficiencias" aria-controls="deficiencias" role="tab" data-toggle="tab"><i
                            class="fa fa-wheelchair-alt"></i> Deficiências</a>
            </li>
            <li role="presentation">
                <a href="#contrato" aria-controls="contrato" role="tab" data-toggle="tab"><i
                            class="fa fa-handshake-o"></i>
                    Contrato</a>
            </li>
            <li role="presentation">
                <a href="#sindicato" aria-controls="sindicato" role="tab" data-toggle="tab"><i class="fa fa-shield"></i>
                    Sindicato</a>
            </li>
            <li role="presentation">
                <a href="#dependentes" aria-controls="dependentes" role="tab" data-toggle="tab"><i
                            class="fa fa-users"></i>
                    Dependentes</a>
            </li>
            <li role="presentation">
                <a href="#horario" aria-controls="horario" role="tab" data-toggle="tab"><i class="fa fa-clock-o"></i>
                    Horários</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="pessoal">
                @include('dashboard.funcionario.new.components.pessoal')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="endereco">
                @include('dashboard.funcionario.new.components.endereco')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="documentos">
                @include('dashboard.funcionario.new.components.documentos', [$ufs])
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="sindicato">
                @include('dashboard.funcionario.new.components.sindicato')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="contrato">
                @include('dashboard.funcionario.new.components.contrato')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="horario">
                @include('dashboard.funcionario.new.components.horario')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="dependentes">
                @include('dashboard.funcionario.new.components.dependentes')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="deficiencias">
                @include('dashboard.funcionario.new.components.deficiencias')
                <div class="clearfix"></div>
            </div>
        </div>
    </form>

@stop

