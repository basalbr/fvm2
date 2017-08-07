@extends('admin.layouts.master')
@section('content')
    <h1>Chat</h1>
    <hr>
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.chat.view.components.tabs')
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="mensagens">
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Nome</label>
                        <div class="form-control">{{$chat->nome}}</div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Nome</label>
                        <div class="form-control">{{$chat->email}}</div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Aberto em</label>
                        <div class="form-control">{{$chat->created_at->format('H:i - d/m/Y')}}</div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Status</label>
                        <div class="form-control status">{{$chat->getStatus()}}</div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Assunto</label>
                        <div class="form-control">{{$chat->assunto}}</div>
                    </div>
                </div>
                <div class="col-sm-12">
                    @if($chat->status !== 'ativo')
                        <a href="{{route('ativarChat', $chat->id)}}" class="btn btn-success"><i class="fa fa-check"></i> Ativar</a>
                    @endif
                    @if($chat->status !=='fechado')
                        <a href="{{route('finalizarChat', $chat->id)}}" class="btn btn-danger"><i class="fa fa-close"></i> Fechar</a>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                @include('admin.components.chat.box', ['model'=>$chat])
            </div>
        </div>
    </div>

@stop