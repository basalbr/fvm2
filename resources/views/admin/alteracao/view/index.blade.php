@extends('dashboard.layouts.master')

@section('content')
    <h1>{{$alteracao->tipo->descricao}}</h1>
    <hr>
    <ul class="nav nav-tabs" role="tablist">
        @include('admin.alteracao.view.components.tabs')
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            @include('admin.alteracao.view.components.informacoes')
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="mensagens">
            @include('admin.components.chat.box', ['model'=>$alteracao])
            <div class="clearfix"></div>

        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="anexos">
            @include('admin.alteracao.view.components.docs')
        </div>
        <hr>
        <div class="col-sm-12">
            <a class="btn btn-default" href="{{route('listSolicitacoesAlteracaoToAdmin')}}"><i
                        class="fa fa-angle-left"></i>
                Voltar para solicitações</a>
            @if($alteracao->status == 'Pendente')
                <a class="btn btn-success" href="{{route('finishAlteracao', $idAlteracao)}}"><i
                            class="fa fa-check"></i>
                    Concluir alteração</a>
                <a class="btn btn-danger" href="{{route('cancelAlteracao', $idAlteracao)}}"><i
                            class="fa fa-close"></i>
                    Cancelar alteração</a>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
@stop