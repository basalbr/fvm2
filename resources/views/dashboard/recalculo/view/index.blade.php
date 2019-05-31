@extends('dashboard.layouts.master')
@section('top-title')
    <a href="{{route('listRecalculosToUser')}}">Recálculos</a> <i
            class="fa fa-angle-right"></i> {{$recalculo->tipo->descricao}} em {{$recalculo->created_at->format('d/m/Y')}}
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab"><i
                        class="fa fa-info-circle"></i>
                Informações</a>
        </li>
        <li role="presentation">
            <a href="#mensagens" aria-controls="mensagens" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Mensagens <span
                        class="badge">{{$recalculo->mensagens()->where('lida','=',0)->where('from_admin','=',1)->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#anexos" aria-controls="anexos" role="tab" data-toggle="tab"><i class="fa fa-download"></i>
                Documentos enviados</a>
        </li>
        @if($recalculo->guia)
            <li class="animated bounceInDown highlight">
                <a href="{{asset(public_path().'storage/'. $recalculo->getTable() . '/'.$recalculo->id . '/' . $recalculo->guia)}}"
                   download><i class="fa fa-download"></i> Guia</a>
            </li>
        @endif
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            @if($recalculo->pagamento->isPending())
                <div class="alert alert-warning animated shake" style="display: block;">O pagamento dessa solicitação
                    está com o
                    status {{$recalculo->pagamento->status}}, é necessário realizar o pagamento para que possamos
                    dar
                    início ao processo.
                </div>
            @endif
            <p class="alert-info alert" style="display: block">Abaixo estão todas as informações dessa solicitação de
                recálculo</p>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Tipo</label>
                    <div class="form-control">{{$recalculo->tipo->descricao}}</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Status</label>
                    <div class="form-control">{{$recalculo->getStatus()}}</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Aberto em</label>
                    <div class="form-control">{{$recalculo->created_at->format('d/m/Y')}}</div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Descrição</label>
                    <div class="form-control">{{$recalculo->descricao}}</div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="mensagens">
            <div class="col-sm-12">
                @if($recalculo->status == 'concluido')
                    @include('dashboard.components.chat.box', ['model'=>$recalculo, 'lockMessages'=> 'true'])
                @else
                    @include('dashboard.components.chat.box', ['model'=>$recalculo])
                @endif
            </div>
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="anexos">
            <div class="col-sm-12">
                <div id="anexos">
                    <div class="col-sm-12">
                        <p>Aqui estão os arquivos enviados nas mensagens.</p>
                    </div>
                    <div class="list">
                        @foreach($recalculo->mensagens as $message)
                            @if($message->anexo)
                                <div class="col-sm-4">
                                    @include('dashboard.components.anexo.withDownload', ['anexo'=>$message->anexo])
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options">
            <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
            @if($recalculo->pagamento->isPending())
                <a class="btn btn-success" href='{{$recalculo->pagamento->getBotaoPagamento()}}'><i
                            class="fa fa-credit-card"></i> Efetuar pagamento</a>
            @endif
        </div>
    </div>
@stop