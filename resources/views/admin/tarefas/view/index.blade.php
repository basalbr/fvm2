@extends('admin.layouts.master')
@section('top-title')
    <a href="{{route('listTarefasToAdmin')}}">Tarefas</a> <i
            class="fa fa-angle-right"></i> {{$tarefa->assunto}}
@stop

@section('content')
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Informações</strong></div>
            <div class="panel-body">
                <ul class="nav nav-tabs nav-tabs-mini" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab">Informações</a>
                    </li>
                    @if($isCriador)
                    <li role="presentation">
                        <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab">Histórico</a>
                    </li>
                        @endif
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
                        @include('admin.tarefas.view.components.informacoes')
                    </div>
                    @if($isCriador)
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
                        @include('admin.tarefas.view.components.historico')
                    </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Mensagens</strong></div>
            <div class="panel-body" id="messages">
                @include('admin.components.chat.box2', ['model'=>$tarefa])</div>
        </div>
    </div>

    <div class="navigation-space"></div>
    <div class="navigation-options animated slideInUp">
        <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
        @if(in_array($tarefa->status, ['em_execucao']) && $isResponsavel)
            <a class="btn btn-success" href="{{route('concluirTarefa', [$tarefa->id])}}"><i
                        class="fa fa-check"></i> Concluir</a>
        @endif
        @if(!in_array($tarefa->status, ['cancelado', 'concluido']) && $isCriador)
            <a class="btn btn-danger" href="{{route('cancelarTarefa', [$tarefa->id])}}"><i
                        class="fa fa-remove"></i> Cancelar</a>
        @endif
        @if(in_array($tarefa->status, ['cancelado', 'concluido']) && $isCriador)
            <a class="btn btn-warning" href="{{route('reabrirTarefa', [$tarefa->id])}}"><i
                        class="fa fa-refresh"></i> Reabrir</a>
        @endif
        @if(in_array($tarefa->status, ['pendente']) && $isResponsavel)
            <a class="btn btn-success" href="{{route('iniciarTarefa', [$tarefa->id])}}"><i
                        class="fa fa-check"></i> Iniciar</a>
        @endif
    </div>
@stop