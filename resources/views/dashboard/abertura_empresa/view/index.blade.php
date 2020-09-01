@extends('dashboard.layouts.master')
@section('top-title')
    <a href="{{route('listAberturaEmpresaToUser')}}">Abertura de empresa</a> <i
            class="fa fa-angle-right"></i> {{$aberturaEmpresa->nome_empresarial1}}
@stop
@section('content')
    @if($aberturaEmpresa->ordemPagamento->isPending())
        <div class="col-xs-12">
            <div class="alert alert-danger visible-lg visible-sm visible-xs visible-md animated shake">
                <p><strong>Atenção!</strong> É necessário efetuar o pagamento do processo para que possamos iniciar o
                    processo de abertura de empresa. Caso tenha alguma dúvida com relação ao processo de abertura basta
                    clicar na aba de 'Mensagens' para interagir com nossa equipe.</p>
                <br/>
                <div class="text-right">
                    <a href="{{$aberturaEmpresa->ordemPagamento->getBotaoPagamento()}}" class="btn btn-warning">
                        Realizar pagamento</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    @endif
    <div class="col-xs-12 hidden-xs">
        <div class="form-group" style="background-color: rgba(255,255,255,0.8)">
            <label for="">Andamento do Processo</label>
            <div class="form-control">
                @include('dashboard.abertura_empresa.view.components.etapas')
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-6">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#principal" aria-controls="principal" role="tab" data-toggle="tab"><i
                            class="fa fa-info"></i><span class="tab-text"> Resumo</span></a>
            </li>
            <li role="presentation">
                <a href="#socios" aria-controls="socios" role="tab" data-toggle="tab"><i class="fa fa-users"></i><span class="tab-text"> Sócios</span></a>
            </li>
            <li role="presentation">
                <a href="#docs" aria-controls="docs" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i><span class="tab-text"> Anexos</span></a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active fadeIn animated" id="principal">
                @include('dashboard.abertura_empresa.view.components.principal')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane fadeIn animated" id="socios">
                @include('dashboard.abertura_empresa.view.components.socios')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn animated" id="docs">
                @include('dashboard.abertura_empresa.view.components.anexos')
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Mensagens</strong></div>
            <div class="panel-body" id="messages">
                @include('dashboard.components.chat.box2', ['model'=>$aberturaEmpresa, 'lock_anexo'=>false])</div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <button class="btn btn-info ver-mensagens visible-xs" type="button" style="float:left">Ver mensagens </button>
        <a class="btn btn-default" href="{{URL::previous()}}"><i
                    class="fa fa-angle-left"></i>
            Voltar</a>
    </div>

@stop

@section('modals')
    @parent
    @include('dashboard.components.socios.view', ['socios' => $aberturaEmpresa->socios])

@stop