var reference, referenceId, lastMessageId, uploadFileUrl, updateAjax = null, readAjax = null;
$(function () {
    reference = $('.messages').data('reference');
    referenceId = $('.messages').data('reference-id');
    uploadFileUrl = $('.messages').data('upload-url');
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
    $('#send-file').on('click', function (e) {
        e.preventDefault()
        $('#file').click();
    });
    $('#file').on('change', function () {
        validateFile($(this));
        $('#file').val(null);
    });

    $('.nav-tabs li').on('click', function () {
        if ($(this).find('a[href="#messages"]').length > 0) {
            setTimeout(function(){
                $('.messages').scrollTop($('.messages')[0].scrollHeight);
            }, 500);
        }
    });

    setInterval(updateChat, 3000);
    setInterval(readMessages, 3000);
});

function readMessages() {
    if (!$('.messages').is(':visible')) {
        return false;
    }
    var info = {
        referencia: reference,
        id_referencia: referenceId,
        from_admin: 1
    };
    if (readAjax !== null) {
        readAjax.abort();
    }
    readAjax = $.post($('.messages').data('read-messages-url'), info)
        .done(function (data, textStatus, jqXHR) {
            $('.message-badge').text('0')
        }).fail(function () {
    });
}

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

function validateFile(file) {
    if (file.val() !== '' &&
        file.val() &&
        file.val() !== undefined) {
        if ((file[0].files[0].size / 1024) > 10240) {
            showModalAlert('O arquivo não pode ser maior que 10MB.');
            return false;
        }
        var formData = new FormData();
        formData.append('arquivo', file[0].files[0]);
        formData.append('referencia', reference);
        formData.append('id_referencia', referenceId);
        if ($('#anexos').find('.list').length > 0) {
            uploadFile(formData, $('#anexos .list'));
        } else {
            uploadFile(formData, false);
        }

    } else {
        showModalAlert('É necessário escolher um arquivo para envio.')
        return false;
    }
}

function uploadFile(formData, target) {
    $.post({
        url: uploadFileUrl,
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (target) {
            target.append($('<div>').addClass('col-sm-4').append(data.html));
        }
    }).fail(function (jqXHR) {
        if (jqXHR.status === 422) {
            //noinspection JSUnresolvedVariable
            showModalAlert('Ocorreu um erro ao tentar enviar o arquivo.');
        } else {
            showModalAlert('Ocorreu um erro ao tentar enviar o arquivo.');
        }
    });
}
function updateChat() {
    var info = {
        referencia: reference,
        id_referencia: referenceId,
        id_ultima_mensagem: lastMessageId
    };
    if (updateAjax !== null) {
        updateAjax.abort();
    }
    updateAjax = $.post($('.messages').data('update-messages-url'), info)
        .done(function (data, textStatus, jqXHR) {
            if (data.messages !== null) {
                $('.no-messages').hide();
                $('.messages').append(data.messages);
                $('.messages').scrollTop($('.messages')[0].scrollHeight);
                $('.message-badge').text(parseInt($('.message-badge').text()) + data.unreadMessages)
            }
            if (data.lastMessageId !== null && data.lastMessageId !== lastMessageId) {
                lastMessageId = data.lastMessageId;
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
        });
}