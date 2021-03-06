var reference, referenceId, lastMessageId, uploadFileUrl, updateAjax = null, readAjax = null, preventSend = false;

$(function () {

    reference = $('.messages').data('reference');
    referenceId = $('.messages').data('reference-id');
    uploadFileUrl = $('.messages').data('upload-url');
    lastMessageId = $('.messages .message').last().data('id') ? $('.messages .message').last().data('id') : 0;
    // organizar mensagens no chat assim que carregar a pagina
    $('.messages').scrollTop($('.messages')[0].scrollHeight);
    resizeElementHeight($('#messages .messages'));
    $('#message').on('keypress', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var content = this.value;
            var caret = getCaret(this);
            if (event.shiftKey) {
                this.value = content.substring(0, caret) + "\n" + content.substring(caret, content.length);
                event.stopPropagation();
            } else {
                sendMessage();
            }
        }
    });
    if ($('a[href="#messages"]').parent().hasClass('active') || $('a[href="#mensagens"]').parent().hasClass('active')) {
        resizeElementHeight($('#messages .messages'));
        readMessages(true);
        setTimeout(function () {
            $('.messages').scrollTop($('.messages')[0].scrollHeight);
        }, 500);
    }
    $(window).resize(function () {
        resizeElementHeight($('#messages .messages'))
    });

    $('#send-message').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        sendMessage();
    });

    $('#send-file').on('click', function (e) {
        e.preventDefault();
        $('#file').click();
    });

    $('#file').on('change', function () {
        validateMessengerFile($(this));
        $('#file').val(null);
    });

    $('.nav-tabs li').on('click', function () {
        if ($(this).find('a[href="#messages"]').length > 0 || $(this).find('a[href="#mensagens"]').length > 0) {
            resizeElementHeight($('#messages .messages'));
            readMessages(true);
            setTimeout(function () {
                $('.messages').scrollTop($('.messages')[0].scrollHeight);
            }, 500);
        }
    });
    setInterval(updateChat, 5000);
    setInterval(readMessages, 5000);

});

function resizeElementHeight(element) {
    var height = 0;
    var body = window.document.body;
    if (window.innerHeight) {
        height = window.innerHeight;
    } else if (body.parentElement.clientHeight) {
        height = body.parentElement.clientHeight;
    } else if (body && body.clientHeight) {
        height = body.clientHeight;
    }
    element.css('height', (height - 335) + "px");
    $('.messages').scrollTop($('.messages')[0].scrollHeight);
}

function readMessages(bypass) {
    if(!document.hasFocus()){
        return false;
    }
    if (preventSend) {
        return false;
    }
    if (!$('.messages').is(':visible') && !bypass) {
        return false;
    }
    var info = {
        referencia: reference,
        id_referencia: referenceId,
        from_admin: 0
    };
    if (readAjax !== null) {
        readAjax.abort();
    }
    readAjax = $.post($('.messages').data('read-messages-url'), info)
        .done(function (data, textStatus, jqXHR) {
            $('a[href="#messages"] .badge, a[href="#mensagens"] .badge').text('0')
        }).fail(function () {
        });
}

function sendMessage() {
    if (preventSend) {
        return false;
    }
    preventSend = true;
    var info = {
        referencia: reference,
        id_referencia: referenceId,
        mensagem: $('#message').val(),
        from_admin: 1
    };
    $('#send-message').addClass('disabled').prop('disabled', true).html('<i class="fa fa-hourglass-1"></i> Enviando mensagem...');
    $('#message').val(null);
    if (readAjax !== null) {
        readAjax.abort();
    }
    if (updateAjax !== null) {
        updateAjax.abort();
    }
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
            $('#send-message').removeClass('disabled').prop('disabled', false).html('<i class="fa fa-send"></i>');
            preventSend = false;
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            showModalValidationError(jqXHR.responseJSON)
            $('#send-message').removeClass('disabled').prop('disabled', false).html('<i class="fa fa-send"></i>');
            preventSend = false;
        });
}

function validateMessengerFile(file) {
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
        formData.append('from_admin', 1);
        if ($('#anexos').find('.list').length > 0) {
            uploadMessengerFile(formData, $('#anexos .list'));
        } else {
            uploadMessengerFile(formData, false);
        }

    } else {
        showModalAlert('É necessário escolher um arquivo para envio.')
        return false;
    }
}

function uploadMessengerFile(formData, target) {
    $('#send-file').addClass('disabled').prop('disabled', true).html('<i class="fa fa-hourglass-1"></i> Enviando, aguarde...');
    $.post({
        url: uploadFileUrl,
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (target) {
            target.append($('<div>').addClass('col-sm-4').append(data.html));
        }
        $('#send-file').removeClass('disabled').prop('disabled', false).html('<i class="fa fa-paperclip"></i>');
    }).fail(function (jqXHR) {
        if (jqXHR.status === 422) {
            //noinspection JSUnresolvedVariable
            showModalAlert('Ocorreu um erro ao tentar enviar o arquivo.');
        } else {
            showModalAlert('Ocorreu um erro ao tentar enviar o arquivo.');
        }
        $('#send-file').removeClass('disabled').prop('disabled', false).html('<i class="fa fa-paperclip"></i>');
    });
}

function updateChat() {
    if(!document.hasFocus()){
        return false;
    }
    if (preventSend) {
        return false;
    }
    if (!$('.messages').is(':visible')) {
        return false;
    }
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