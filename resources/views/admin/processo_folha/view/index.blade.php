@extends('admin.layouts.master')
@section('content')
    <h1>Apuração de Folha ({{$processo->competencia->format('m/Y')}})</h1>
    <hr>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab"><i
                        class="fa fa-info-circle"></i>
                Informações</a>
        </li>
        <li role="presentation">
            <a href="#mensagens" aria-controls="mensagens" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Mensagens <span
                        class="badge">{{$processo->mensagens()->where('lida','=',0)->where('from_admin','=',0)->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#anexos" aria-controls="anexos" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i>
                Documentos enviados</a>
        </li>
        @if($processo->recibo_folha)
            <li class="animated bounceInDown highlight">
                <a href="{{asset(public_path().'storage/anexos/'. $processo->getTable() . '/'.$processo->id . '/' . $processo->recibo_folha)}}"
                   download><i class="fa fa-download"></i> Recibo de Pagamento</a>
            </li>
        @endif
        @if($processo->inss)
            <li class="animated bounceInDown highlight">
                <a href="{{asset(public_path().'storage/anexos/'. $processo->getTable() . '/'.$processo->id . '/' . $processo->inss)}}"
                   download><i class="fa fa-download"></i> INSS</a>
            </li>
        @endif
        @if($processo->irrf)
            <li class="animated bounceInDown highlight">
                <a href="{{asset(public_path().'storage/anexos/'. $processo->getTable() . '/'.$processo->id . '/' . $processo->irrf)}}"
                   download><i class="fa fa-download"></i> IRRF</a>
            </li>
        @endif
        @if($processo->fgts)
            <li class="animated bounceInDown highlight">
                <a href="{{asset(public_path().'storage/anexos/'. $processo->getTable() . '/'.$processo->id . '/' . $processo->fgts)}}"
                   download><i class="fa fa-download"></i> FGTS</a>
            </li>
        @endif
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">

            <div class="col-sm-12">
                <h3>Informações</h3>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Nome Fantasia</label>
                    <div class="form-control">{{$processo->empresa->nome_fantasia}}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Razão Social</label>
                    <div class="form-control">{{$processo->empresa->razao_social}}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Competência</label>
                    <div class="form-control">{{$processo->competencia->format('m/Y')}}</div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="mensagens">
                @include('admin.components.chat.box', ['model'=>$processo])
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="docs">
            <div class="col-sm-12">
                <div id="anexos">
                    <div class="list">
                        @foreach($processo->mensagens as $message)
                            @if($message->anexo)
                                <div class="col-sm-4">
                                    @include('admin.components.anexo.withDownload', ['anexo'=>$message->anexo])
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                </div>
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