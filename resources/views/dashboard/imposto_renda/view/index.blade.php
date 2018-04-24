@extends('dashboard.layouts.master')

@section('top-title')
    <a href="{{route('listImpostoRendaToUser')}}">Imposto de Renda</a> <i
            class="fa fa-angle-right"></i> Declaração de {{$ir->declarante->nome}}
@stop

@section('content')
    <!-- Nav tabs -->
    @include('dashboard.imposto_renda.view.components.tabs')

    <form class="form" method="POST" action="" id="form-principal">
        {{csrf_field()}}
        <input type="hidden" name="exercicio" value="{{$anoAnterior}}">
    @include('dashboard.components.disable-auto-complete')
    <!-- Tab panes -->
        <div class="tab-content">
            @include('dashboard.components.form-alert')
            <div class="clearfix"></div>
            @include('dashboard.imposto_renda.view.components.tab-geral')
            <div role="tabpanel" class="tab-pane animated fadeIn" id="messages">
                <div class="col-sm-12">
                    @include('dashboard.components.chat.box', ['model'=>$ir])
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="navigation-options">
                <a class="btn btn-default" href="{{URL::previous()}}"><i
                            class="fa fa-angle-left"></i>
                    Voltar</a>
            </div>

        </div>
    </form>
@stop
