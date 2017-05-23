@extends('dashboard.layouts.master')
@section('js')
    @parent
    <script type="text/javascript">
        var reference, referenceId, lastMessageId;

        $(function () {
            reference = $('.messages').data('reference');
            referenceId = $('.messages').data('reference-id');
            lastMessageId = $('.messages .message').last().data('id') ? $('.messages .message').last().data('id') : 0;
            // organizar mensagens no chat assim que carregar a pagina
            $('.messages').scrollTop($('.messages')[0].scrollHeight);
            $('#send-message').on('click', function (e) {
                e.preventDefault();
                sendMessage();
            });
            setInterval(updateChat, 3000);
        });

        function sendMessage() {
            var info = {
                reference: reference,
                referenceId: referenceId,
                message: $('#message').val()
            };
            $.post($('.messages').data('send-message-url'), info)
                .done(function (data, textStatus, jqXHR) {
                    if (data.messages !== null) {
                        $('.no-messages').hide();
                        $('.messages').append(data.messages);
                        $('.messages').scrollTop($('.messages')[0].scrollHeight);
                    }
                    if (data.lastMessageId !== null && data.lastMessageId !== lastMessageId) {
                        lastMessageId = data.lastMessageId;
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422) {
                        //noinspection JSUnresolvedVariable
//                        showFormValidationError($('#message-form'), jqXHR.responseJSON);
                    } else {
                        console.log(jqXHR, textStatus, errorThrown)
//                        showFormValidationError($('#message-form'));
                    }
                });
        }

        function updateChat() {
            var info = {
                reference: reference,
                referenceId: referenceId,
                lastMessageId: lastMessageId
            };
            $.post($('.messages').data('update-messages-url'), info)
                .done(function (data, textStatus, jqXHR) {
                    if (data.messages !== null) {
                        $('.no-messages').hide();
                        $('.messages').append(data.messages);
                        $('.messages').scrollTop($('.messages')[0].scrollHeight);
                    }
                    if (data.lastMessageId !== null && data.lastMessageId !== lastMessageId) {
                        lastMessageId = data.lastMessageId;
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422) {
                        //noinspection JSUnresolvedVariable
                        showFormValidationError($('#message-form'), jqXHR.responseJSON);
                    } else {
                        showFormValidationError($('#message-form'));
                    }
                });
        }
    </script>
@stop
@section('content')
    <h1>Abertura de Empresa</h1>
    <hr>
    <form class="form" method="POST" action="">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#resumo" aria-controls="resumo" role="tab" data-toggle="tab"><i class="fa fa-calculator"></i>
                    Resumo</a>
            </li>
            <li role="presentation">
                <a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab"><i class="fa fa-info"></i>
                    Informações da empresa</a>
            </li>
            <li role="presentation">
                <a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab"><i
                            class="fa fa-address-card"></i> Endereço</a>
            </li>
            <li role="presentation">
                <a href="#socios" aria-controls="socios" role="tab" data-toggle="tab"><i class="fa fa-users"></i> Sócios</a>
            </li>
            <li role="presentation">
                <a href="#cnae" aria-controls="cnae" role="tab" data-toggle="tab"><i class="fa fa-list"></i>
                    CNAEs</a>
            </li>

        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="resumo">
                @include('dashboard.abertura_empresa.view.components.resumo')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="empresa">
                @include('dashboard.abertura_empresa.view.components.info_empresa')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="endereco">
                @include('dashboard.abertura_empresa.view.components.endereco')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="socios">
                @include('dashboard.abertura_empresa.view.components.socios')
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="cnae">
                @include('dashboard.abertura_empresa.view.components.cnae')
                <div class="clearfix"></div>
            </div>

        </div>
    </form>

@stop

