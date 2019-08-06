@extends('dashboard.layouts.master')
@section('top-title')
    <a href="{{route('listReunioesToUser')}}">Reuniões</a> <i
            class="fa fa-angle-right"></i> Detalhes
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
                        class="badge">{{$reuniao->mensagens()->where('lida','=',0)->where('from_admin','=',1)->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#anexos" aria-controls="anexos" role="tab" data-toggle="tab"><i class="fa fa-download"></i>
                Documentos enviados</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            @if($reuniao->pagamento->isPending())
                <div class="alert alert-warning animated shake" style="display: block;">É necessário realizar o
                    pagamento dessa solicitação para que possamos confirmar a reunião.<br/><a class="" style="color: #fff"
                                                                                              href='{{$reuniao->pagamento->getBotaoPagamento()}}'><i
                                class="fa fa-credit-card"></i> Clique aqui para realizar o pagamento de {{$reuniao->pagamento->formattedValue()}}</a>
                </div>
            @endif
            <p class="alert-info alert" style="display: block">Abaixo estão todas as informações dessa solicitação.</p>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Data</label>
                    <div class="form-control">{{$reuniao->data->format('d/m/Y')}} (<strong>{{$reuniao->quantoFalta()}}</strong>)</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Horário</label>
                    <div class="form-control">{{$reuniao->horario->hora_inicial}}
                        - {{$reuniao->horario->hora_final}}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Status</label>
                    <div class="form-control">{!! $reuniao->getLabelStatus() !!} {!! $reuniao->pagamento->isPending() ? '<span class="label label-warning">Pagamento pendente</span>' : ''!!}</div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>Assunto</label>
                    <div class="form-control">{{$reuniao->assunto}}</div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="mensagens">
            <div class="col-sm-12">
                @if($reuniao->status == 'concluido')
                    @include('dashboard.components.chat.box', ['model'=>$reuniao, 'lockMessages'=> 'true'])
                @else
                    @include('dashboard.components.chat.box', ['model'=>$reuniao])
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
                        @foreach($reuniao->mensagens as $message)
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
            @if($reuniao->pagamento->isPending())
                <a class="btn btn-success" href='{{$reuniao->pagamento->getBotaoPagamento()}}'><i
                            class="fa fa-credit-card"></i> Efetuar pagamento</a>
            @endif
        </div>
    </div>
@stop