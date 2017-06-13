@extends('dashboard.layouts.master')
@section('js')
    @parent
    <script type="text/javascript"
            src="{{url(public_path().'js/dashboard/funcionario/view/index.js')}}"></script>
@stop
@section('content')
    <div class="col-xs-12">
        <h1>{{$funcionario->nome_completo}}
            <small> ({!! $funcionario->getStatus() !!})</small>
        </h1>
        <h4><a href="{{route('showEmpresaToUser', $empresa->id)}}">{{$empresa->nome_fantasia}}</a></h4>
        <hr>
    </div>
    <div class="col-sm-12">
        <a class="btn btn-primary"
           href="{{route('listDocumentosFuncionarioToUser', [$empresa->id, $funcionario->id])}}">
            <i class="fa fa-files-o"></i> Ver documentos
        </a>
        @if($funcionario->status == 'aprovado')
            <a class="btn btn-danger"
               href="{{route('', [$empresa->id, $funcionario->id])}}">
                <i class="fa fa-minus-circle"></i> Solicitar demissão
            </a>
        @endif
        <hr>
    </div>
    <div class="clearfix"></div>
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
            <div role="tabpanel" class="tab-pane active animated fadeIn" id="pessoal">
                @include('dashboard.funcionario.view.components.pessoal')
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
        </div>
    </form>

@stop

