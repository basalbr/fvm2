@extends('admin.layouts.master')
@section('top-title')
    <a href="{{route('listTarefasToAdmin')}}">Tarefas</a> <i class="fa fa-angle-right"></i> {{$tarefa->descricao}}
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#info" aria-controls="envio" role="tab" data-toggle="tab"><i
                        class="fa fa-info"></i> Informações
            </a>
        </li>
        <li role="presentation">
            <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Comentários</a>
        </li>
        <li role="presentation">
            <a href="#atividades" aria-controls="atividades" role="tab" data-toggle="tab"><i class="fa fa-list"></i>
                Atividades</a>
        </li>
        <li role="presentation">
            <a href="#anexos" aria-controls="anexos" role="tab" data-toggle="tab"><i class="fa fa-clipboard"></i>
                Anexos</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="info">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Descrição</label>
                    <div class="form-control">
                        {{$tarefa->descricao}}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Referência</label>
                    <div class="form-control">
                        {!! $tarefa->getReferenciaLink() !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Status</label>
                    <div class="form-control">
                        {{$tarefa->getStatus()}}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Responsável</label>
                    <div class="form-control">
                        {{$tarefa->responsavel->nome}}
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
        <div class="navigation-space"></div>
        <div class="navigation-options animated slideInUp">
            <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
        </div>
        <div class="clearfix"></div>
    </div>
@stop
