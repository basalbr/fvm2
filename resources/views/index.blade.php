@extends('layouts.master')

@if(isset($login))
@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#modal-access').modal('show');
        })
    </script>
@stop
@endif

@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'js/modules/simulate.js')}}"></script>
@stop


@section('content')

    <section id="main-banner" class="section">
        <input type="hidden" value="{{route('getMonthlyPaymentParams')}}" id="payment-parameters">

        @include('index.components.banner-principal')
    </section>
    <section id="como-funciona" class="section">
        @include('index.components.como-funciona')
    </section>

    <section id="mensalidade" class="section">
        @include('index.components.mensalidade')
    </section>

    <section id="duvidas" class="section">
        @include('index.components.duvidas')
    </section>
    @if($atendimento)
    <button class="btn-chat btn">
        <i class="fa fa-comment"></i> Fale conosco
    </button>
    <div id="chat-window" class="animated fadeInUp"
         data-send-message-url="{{route('sendMessageChatAjax')}}"
         data-update-chat-url="{{route('updateChatAjax')}}"
         data-register-chat-url="{{route('registerChat')}}">
        <div id="information">
            <form class="form">
                @include('admin.components.disable-auto-complete')
                <div class="form-group">
                    <label>Seu nome</label>
                    <input class="form-control" name="nome" placeholder="Digite seu nome"/>
                </div>
                <div class="form-group">
                    <label>Seu e-mail</label>
                    <input class="form-control" name="email" placeholder="Digite seu e-mail"/>
                </div>
                <div class="form-group">
                    <label>Assunto</label>
                    <textarea class="form-control" name="assunto" placeholder="Sobre o que deseja falar?"></textarea>
                </div>
                <button class="btn btn-primary btn-block"><i class="fa fa-comment"></i> Solicitar atendimento</button>
                <button class="btn btn-default btn-block"><i class="fa fa-close"></i> Cancelar</button>
            </form>
        </div>
        <div id="messages" class="animated fadeIn">
            <div class="message-box">
                <div class="message from-admin animated fadeInRight">
                    <div class="nome">Sistema</div>
                    Por favor aguarde, logo você será atendido.
                </div>
            </div>
            <div class="user-input">
                <textarea disabled="disabled" class="form-control"></textarea>
                <button class="btn btn-primary" disabled="disabled"><i class="fa fa-send"></i> Enviar</button>
                <button class="btn btn-default"><i class="fa fa-close"></i> Fechar</button>
            </div>
        </div>
    </div>
@endif
    <div class="clearfix"></div>
@stop
