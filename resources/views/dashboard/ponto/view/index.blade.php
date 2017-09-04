@extends('dashboard.layouts.master')
@section('top-title')
    <a href="{{route('listPontosToUser')}}">Registros de Ponto</a> <i class="fa fa-angle-right"></i> <a
            href="{{route('showEmpresaToUser', $ponto->empresa->id)}}">{{$ponto->empresa->nome_fantasia}}</a>
    <i class="fa fa-angle-right"></i> Envio de Pontos
@stop
@section('content')
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
                <a href="{{route('showProcessoFolhaToUser', $ponto->getProcesso()->id)}}"><i class="fa fa-external-link"></i> Ver recibos de pagamento</a>
            </li>
        @endif
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="envio">
            <div class="col-xs-12">
                @if($ponto->status=='pendente')
                    <p>Olá {{Auth::user()->nome}}, precisamos que você envie <strong>todos</strong> os pontos dos
                        funcionários e após enviar <strong>todos</strong> eles, clique no botão <strong>concluir
                            envio</strong>.<br/> Somente após você concluir o envio dos documentos é que poderemos
                        continuidade no processo.</p>
                @else
                    <p>{{Auth::user()->nome}}, abaixo estão os registros que você enviou, clique em download para baixar
                        e visualizar.</p>
                @endif
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Empresa</label>
                    <div class="form-control">
                        <a href="{{route('showEmpresaToUser', $ponto->empresa->id)}}">{{$ponto->empresa->nome_fantasia}}
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
            @include('dashboard.components.uploader.default', ['idReferencia'=>$ponto->id, 'referencia'=>$ponto->getTable(), 'anexos' => $ponto->anexos()->orderBy('created_at', 'desc')->get(), 'lock'=>$ponto->status == 'pendente' ? false : true])
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="messages">
            <div class="col-sm-12">
                @if($ponto->status == 'concluido')
                    @include('dashboard.components.chat.box', ['model'=>$ponto, 'lockMessages'=>'true'])
                @else
                    @include('dashboard.components.chat.box', ['model'=>$ponto])
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options animated slideInUp">

            <a class="btn btn-default" href="{{URL::previous()}}"><i
                        class="fa fa-angle-left"></i>
                Voltar</a>
            @if($ponto->status == 'pendente')
                <a class="btn btn-success" href="{{route('sendPontos', $ponto->id)}}"><i
                            class="fa fa-check"></i>
                    Concluir envio</a>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
@stop
