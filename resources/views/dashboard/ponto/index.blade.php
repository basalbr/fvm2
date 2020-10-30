@extends('dashboard.layouts.master')
@section('top-title')
    Registros de Ponto
@stop
@section('video-ajuda')
    <li><a id="btn-ajuda" data-placement="bottom" title="Precisa de ajuda? Veja nosso vídeo explicativo sobre essa página!" href="" data-toggle="modal" data-target="#modal-video-ajuda"><span class="fa fa-youtube-play"></span>
            Ajuda</a></li>
@stop
@section('modal-video-ajuda-titulo', 'Como enviar os registros de ponto')
@section('modal-video-ajuda-embed')
    <iframe width="560" height="315" src="https://www.youtube.com/embed/qojyyPl5Znk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Pendentes <span class="badge">{{$pontosPendentes->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
                Concluídos</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <div class="col-sm-12">
                <p class="alert alert-info" style="display: block"><strong>Abaixo estão as pendências de envio de registro de ponto</strong>, basta clicar em Visualizar para enviar os registros do período.</p>
            </div>
            <div class="col-sm-12">
                <table class="table table-hovered table-striped">
                    <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Período</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @if($pontosPendentes->count())
                        @foreach($pontosPendentes as $ponto)
                            <tr>
                                <td>{{$ponto->empresa->nome_fantasia}}</td>
                                <td>{{$ponto->periodo->format('m/Y')}}</td>
                                <td>{!! $ponto->getLabelStatus()!!}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{route('showPontoToUser', $ponto->id)}}"
                                       title="Visualizar">
                                        <i class="fa fa-search"></i> Visualizar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">Nenhuma solicitação de envio de registro de ponto</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
                <div class="col-sm-12">
                <table class="table table-hovered table-striped">
                    <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Período</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @if($pontosConcluidos->count())
                        @foreach($pontosConcluidos as $ponto)
                            <tr>
                                <td>{{$ponto->empresa->nome_fantasia}}</td>
                                <td>{{$ponto->periodo->format('m/Y')}}</td>
                                <td>{{$ponto->getStatus()}}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{route('showPontoToUser', $ponto->id)}}"
                                       title="Visualizar">
                                        <i class="fa fa-search"></i> Visualizar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">Nenhum encontrado</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop
@section('modals')
    @parent
    @include('dashboard.modals.video-ajuda')
@stop