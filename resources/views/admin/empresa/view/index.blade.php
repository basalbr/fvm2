@extends('admin.layouts.master')
@section('content')
    <h1>{{$empresa->nome_fantasia}}
        <small>{{$empresa->razao_social}}</small>
    </h1>
    <hr>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#principal" aria-controls="principal" role="tab" data-toggle="tab"><i class="fa fa-home"></i>
                Principal</a>
        </li>
        <li role="presentation">
            <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Mensagens <span
                        class="badge message-badge">{{$empresa->mensagens()->where('lida','=',0)->where('from_admin','=',0)->count()}}</span></a>
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
        <div role="tabpanel" class="tab-pane active" id="principal">
            @include('admin.empresa.view.components.principal')
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="messages">
            <div class="col-xs-12">
                @include('admin.components.chat.box', ['model'=>$empresa])
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="empresa">
            @include('admin.empresa.view.components.info_empresa')
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="endereco">
            @include('admin.empresa.view.components.endereco')
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="socios">
            @include('admin.empresa.view.components.socios')
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="cnae">
            @include('admin.empresa.view.components.cnae')
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="docs">
            <div class="col-sm-12">
                <div id="anexos">
                    <div class="list">
                        @if($empresa->anexos)
                            @foreach($empresa->anexos as $anexo)
                                <div class="col-sm-4">
                                    @include('admin.components.anexo.withDownload', ['anexo'=>$anexo])
                                </div>
                            @endforeach
                        @endif
                        @foreach($empresa->mensagens as $message)
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
        <div class="navigation-options">
            <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
            @if($empresa->status != 'Aprovado')
                <a href="{{route('activateEmpresa', $empresa->id)}}" class="btn btn-success"><i class="fa fa-check"></i> Ativar empresa</a>
            @endif
        </div>
    </div>

@stop

@section('modals')
    @parent
    @include('admin.components.socios.view', ['socios' => $empresa->socios])
@stop