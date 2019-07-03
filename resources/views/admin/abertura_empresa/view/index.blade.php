@extends('admin.layouts.master')
@include('admin.components.annotation-menu', ['model'=>$aberturaEmpresa])
@section('top-title')
    <a href="{{route('listAberturaEmpresaToAdmin')}}">Abertura de empresa</a> <i
            class="fa fa-angle-right"></i> {{$aberturaEmpresa->nome_empresarial1}}
@stop
@section('content')
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#principal" aria-controls="principal" role="tab" data-toggle="tab"><i class="fa fa-home"></i>
                Principal</a>
        </li>
        <li role="presentation">
            <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Mensagens <span
                        class="badge message-badge">{{$aberturaEmpresa->mensagens()->where('lida','=',0)->where('from_admin','=',0)->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab"><i class="fa fa-info"></i>
                Informações</a>
        </li>
        <li role="presentation">
            <a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab"><i
                        class="fa fa-address-card"></i> Endereço</a>
        </li>
        <li role="presentation">
            <a href="#socios" aria-controls="socios" role="tab" data-toggle="tab"><i class="fa fa-users"></i> Sócios</a>
        </li>
        <li role="presentation">
            <a href="#cnae" aria-controls="cnae" role="tab" data-toggle="tab"><i class="fa fa-list"></i>
                CNAEs</a>
        </li>
        <li role="presentation">
            <a href="#docs" aria-controls="docs" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i>
                Documentos enviados</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        @if($aberturaEmpresa->ordemPagamento->isPending())
            <div class="col-xs-12">
                <p class="alert alert-danger visible-lg visible-sm visible-xs visible-md animated shake">O pagamento desse
                    processo ainda está pendente.</p>
            </div>
        @endif
        @if($aberturaEmpresa->status == 'concluido')
            <div class="col-xs-12">
                <p class="alert alert-success visible-lg visible-sm visible-xs visible-md animated shake">Esse processo
                    encontra-se concluído.</p>
            </div>
        @endif
        @if($aberturaEmpresa->status == 'cancelado')
            <div class="col-xs-12">
                <p class="alert alert-danger visible-lg visible-sm visible-xs visible-md animated shake">Esse processo
                    encontra-se cancelado.</p>
            </div>
        @endif
        <div role="tabpanel" class="tab-pane active" id="principal">
            @include('admin.abertura_empresa.view.components.principal')
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="messages">
            @include('admin.components.chat.box', ['model'=>$aberturaEmpresa])
        </div>
        <div role="tabpanel" class="tab-pane" id="empresa">
            @include('admin.abertura_empresa.view.components.info_empresa')
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="endereco">
            @include('admin.abertura_empresa.view.components.endereco')
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="socios">
            @include('admin.abertura_empresa.view.components.socios')
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="cnae">
            @include('admin.abertura_empresa.view.components.cnae')
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="docs">
            <div class="col-sm-12">
                <div id="anexos">
                    <div class="list">
                        @if($aberturaEmpresa->anexos)
                            @foreach($aberturaEmpresa->anexos as $anexo)
                                <div class="col-sm-4">
                                    @include('admin.components.anexo.withDownload', ['anexo'=>$anexo])
                                </div>
                            @endforeach
                        @endif
                        @foreach($aberturaEmpresa->mensagens as $message)
                            @if($message->anexo)
                                <div class="col-sm-4">
                                    @include('admin.components.anexo.withDownload', ['anexo'=>$message->anexo])
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options animated slideInUp">
            <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
            @if(!in_array($aberturaEmpresa->status, ['cancelado', 'concluido']))
                <a href="{{route('createEmpresaFromAberturaEmpresa', $aberturaEmpresa->id)}}" class="btn btn-success"><i
                            class="fa fa-check"></i>
                    Transformar em empresa</a>
            @endif
        </div>
    </div>
@stop

@section('modals')
    @parent
    @include('admin.components.socios.view', ['socios' => $aberturaEmpresa->socios])
@stop