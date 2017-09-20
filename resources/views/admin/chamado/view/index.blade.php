@extends('admin.layouts.master')
@include('admin.components.annotation-menu', ['model'=>$chamado])
@section('top-title')
    <a href="{{route('listAtendimentosToAdmin')}}">Atendimento</a> <i class="fa fa-angle-right"></i> <a
            href="{{route('showChamadoToAdmin', $chamado->id)}}">Chamado ({{$chamado->tipoChamado->descricao}})</a>
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.chamado.view.components.tabs')
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="messages">
            <div class="col-xs-12">
                <p>Empresas de {{$chamado->usuario->nome}}</p>
                <ul class="list-group">
                    @foreach($chamado->usuario->empresas as $empresa)
                        <li class="list-group-item"><a href="{{route('showEmpresaToAdmin', $empresa->id)}}">{{$empresa->nome_fantasia}} ({{$empresa->razao_social}})</a></li>
                    @endforeach
                </ul>
            </div>
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
                <a href="{{route('reopenChamado', $chamado->id)}}" class="btn-primary btn"><i
                            class="fa fa-envelope-open"></i> Reabrir</a>
            @endif
            @if($chamado->status!='Concluído')
                <a href="{{route('finishChamado', $chamado->id)}}" class="btn-success btn"><i class="fa fa-check"></i>
                    Concluir</a>
            @endif
        </div>
    </div>
@stop