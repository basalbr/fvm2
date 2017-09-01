@extends('admin.layouts.master')

@section('content')
    <h1>Envio de registro de ponto<small> {{$ponto->periodo->format('m/Y')}}</small></h1>
    <hr>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#envio" aria-controls="envio" role="tab" data-toggle="tab"><i
                        class="fa fa-upload"></i>
                Envio de Registros</a>
        </li>
        <li role="presentation">
            <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Mensagens <span
                        class="badge">{{$ponto->mensagens()->where('lida','=',0)->where('from_admin','=',1)->count()}}</span></a>
        </li>
        @if($ponto->isFinished())
            <li class="animated bounceInDown highlight">
                <a href="{{route('showProcessoFolhaToAdmin', $ponto->getProcesso()->id)}}"><i class="fa fa-external-link"></i> Ver guias</a>
            </li>
        @endif
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="envio">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Empresa</label>
                    <div class="form-control">
                        <a href="{{route('showEmpresaToAdmin', $ponto->empresa->id)}}">{{$ponto->empresa->nome_fantasia}}
                            ({{$ponto->empresa->razao_social}})</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Status</label>
                    <div class="form-control">
                        {{$ponto->getStatus()}}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Período</label>
                    <div class="form-control">
                        {{$ponto->periodo->format('m/Y')}}
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            @include('admin.components.uploader.default', ['idReferencia'=>$ponto->id, 'referencia'=>$ponto->getTable(), 'anexos' => $ponto->anexos()->orderBy('created_at', 'desc')->get(), 'lock'=>$ponto->status == 'pendente' ? false : true])
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="messages">
            <div class="col-sm-12">
                @if($ponto->status == 'concluido')
                    @include('admin.components.chat.box', ['model'=>$ponto, 'lockMessages'=>'true'])
                @else
                    @include('admin.components.chat.box', ['model'=>$ponto])
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-sm-12">

            <a class="btn btn-default" href="{{route('listPontosToUser')}}"><i
                        class="fa fa-angle-left"></i>
                Voltar para listagem</a>
            @if($ponto->status == 'pendente')
                <a class="btn btn-success" href="{{route('sendPontos', $ponto->id)}}"><i
                            class="fa fa-check"></i>
                    Concluir envio</a>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
@stop
