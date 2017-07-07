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
        <hr>
        <div class="col-sm-12">
            <a class="btn btn-default" href="{{route('listDocumentosContabeisToUser')}}"><i
                        class="fa fa-angle-left"></i>
                Voltar para documentos contábeis</a>
        </div>
        <div class="clearfix"></div>
    </div>
@stop