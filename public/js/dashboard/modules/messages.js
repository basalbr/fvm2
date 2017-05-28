var reference, referenceId, lastMessageId;
$(function () {
    reference = $('.messages').data('reference');
    referenceId = $('.messages').data('reference-id');
    lastMessageId = $('.messages .message').last().data('id') ? $('.messages .message').last().data('id') : 0;
    // organizar mensagens no chat assim que carregar a pagina
    $('.messages').scrollTop($('.messages')[0].scrollHeight);
    $('#message').on('keypress', function (e) {
        console.log('a');
        if (e.keyCode == 13) {
            e.preventDefault();
            sendMessage();
        }
    });
    $('#send-message').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        sendMessage();
    });
    setInterval(updateChat, 3000);
});

function sendMessage() {
    var info = {
        referencia: reference,
        id_referencia: referenceId,
        mensagem: $('#message').val()
    };
    $('#message').val(null);

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
            showModalValidationError(jqXHR.responseJSON)
        });

}

function updateChat() {
    var info = {
        referencia: reference,
        id_referencia: referenceId,
        id_ultima_mensagem: lastMessageId
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