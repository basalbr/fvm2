@extends('admin.layouts.master')

@section('top-title')
    <a href="{{route('listDecimoTerceiroToAdmin')}}">Décimo Terceiro</a> <i
            class="fa fa-angle-right"></i> Enviar documentos
@stop

@section('content')
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#principal" aria-controls="principal" role="tab" data-toggle="tab"><i class="fa fa-home"></i>
                Principal</a>
        </li>
        <li role="presentation">
            <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i
                        class="fa fa-comments"></i>
                Mensagens
                <span class="badge message-badge">{{$decimoTerceiro->mensagens()->where('lida','=',0)->where('from_admin','=',0)->count()}}</span>
            </a>
        </li>
        <li role="presentation">
            <a href="#docs" aria-controls="docs" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i>
                Documentos enviados</a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="active tab-pane animated fadeIn" id="principal">
            @include('dashboard.components.form-alert')
            @include('dashboard.components.disable-auto-complete')
            {{csrf_field()}}
            <div class="col-xs-12">
                <p>Abaixo se encontram os documentos relacionados ao décimo terceiro enviados para o usuário <a
                            href="{{route('showUsuarioToAdmin', $decimoTerceiro->empresa->id_usuario)}}">{{$decimoTerceiro->empresa->usuario->nome}}</a>.
                </p>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label>Empresa *</label>
                    <div class="form-control">
                        <a href="{{route('showEmpresaToAdmin', $decimoTerceiro->id_empresa)}}">
                            {{$decimoTerceiro->empresa->razao_social}} ({{$decimoTerceiro->empresa->nome_fantasia}})
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label>Descrição dos documentos *</label>
                    <div class="form-control">{{$decimoTerceiro->descricao}}</div>
                </div>
            </div>
            @include('admin.components.uploader.default',['lock'=>true, 'reference'=>$decimoTerceiro->getTable(), 'referenceId'=>$decimoTerceiro->id, 'anexos'=>$decimoTerceiro->anexos])
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="messages">
            @include('admin.components.chat.box', ['model'=>$decimoTerceiro])
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="docs">
                    @php($hasAnexo = false)
                    @if($decimoTerceiro->anexos)
                        @foreach($decimoTerceiro->anexos as $anexo)
                            @php($hasAnexo = true)
                            <div class="col-sm-4">
                                @include('dashboard.components.anexo.withDownload', ['anexo'=>$anexo])
                            </div>
                        @endforeach
                    @endif
                    @foreach($decimoTerceiro->mensagens as $message)
                        @if($message->anexo)
                            @php($hasAnexo = true)
                            <div class="col-sm-4">
                                @include('dashboard.components.anexo.withDownload', ['anexo'=>$message->anexo])
                            </div>
                        @endif
                    @endforeach
                    @if(!$hasAnexo)
                        <div class="col-xs-12 text-center">
                            <h3>Nenhum documento enviado</h3>
                        </div>
                    @endif
                <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options">
            <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
        </div>
    </div>
@stop