@extends('admin.layouts.master')

@section('content')
    <h1>Chamado: {{$chamado->tipoChamado->descricao}}</h1>
    <hr>
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.chamado.view.components.tabs')
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="messages">
            @include('admin.components.chat.box', ['model'=>$chamado])
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="docs">
            @include('admin.chamado.view.components.docs')
        </div>
        <div class="clearfix"></div>

        <div class="navigation-space"></div>
        <div class="navigation-options animated slideInUp">
            <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
            @if($chamado->status!='Aberto')
                <a href="{{route('reopenChamado', $chamado->id)}}" class="btn-primary btn"><i class="fa fa-envelope-open"></i> Reabrir</a>
            @endif
            @if($chamado->status!='Concluído')
                <a href="{{route('finishChamado', $chamado->id)}}" class="btn-success btn"><i class="fa fa-check"></i> Concluir</a>
            @endif
        </div>

    </div>

@stop