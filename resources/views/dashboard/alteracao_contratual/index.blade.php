@extends('dashboard.layouts.master')
@section('top-title')
    Alterações Contratuais
@stop
@section('video-ajuda')
    <li><a id="btn-ajuda" data-placement="bottom" title="Precisa de ajuda? Veja nosso vídeo explicativo sobre essa página!" href="" data-toggle="modal" data-target="#modal-video-ajuda"><span class="fa fa-youtube-play"></span>
            Ajuda</a></li>
@stop
@section('modal-video-ajuda-titulo', 'Como solicitar alteração contratual')
@section('modal-video-ajuda-embed')
    <iframe width="560" height="315" src="https://www.youtube.com/embed/MhajGUZm5Kk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
@stop
@section('content')

    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Alterações</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Tipo de alteração</th>
                    <th>Data de alteração</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @if($alteracoes->count())
                    @foreach($alteracoes as $alteracao)
                        <tr>
                            <td>{{$alteracao->tipo->descricao}}</td>
                            <td>{{$alteracao->data_alteracao->format('d/m/Y')}}</td>
                            <td>{{$alteracao->getStatus()}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showAlteracaoContratualToUser', [$alteracao->funcionario->id, $alteracao->id])}}" title="Visualizar">
                                    <i class="fa fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">Nenhuma solicitação de alteração encontrada</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="col-xs-12 navigation-options">
            <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
            @if($funcionario->status == 'ativo')
                <a class="btn btn-primary"
                   href="{{route('newAlteracaoContratual', [$funcionario->id])}}">
                    <i class="fa fa-edit"></i> Solicitar nova alteração
                </a>
            @endif
        </div>
    </div>
    <div class="clearfix"></div>

@stop
@section('modals')
    @parent
    @include('dashboard.modals.video-ajuda')
@stop
