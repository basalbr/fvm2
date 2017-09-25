var chatId, nome, email, assunto, lastMessageId, updateInterval, updateAjax = null;

$(function () {
    $('.btn-chat').on('click', function (e) {
        e.preventDefault();
        openChatWindow();
    });

    $('#chat-window .btn-default').on('click', function (e) {
        e.preventDefault();
        closeChatWindow();
    });

    $('#chat-window #information .btn-primary').on('click', function (e) {
        e.preventDefault();
        nome = $(this).parent().find('[name="nome"]').val();
        email = $(this).parent().find('[name="email"]').val();
        assunto = $(this).parent().find('[name="assunto"]').val();
        loginChat();
    });

    $('#messages textarea').on('keypress', function (e) {
        if (e.keyCode == 13 && $(this).val() !== '') {
            sendMessage();
        }
    });

    $('#messages .btn-primary').on('click', function (e) {
        e.preventDefault();
        if ($('#messages textarea').val() !== '') {
            sendMessage();
        }
    });


    $('#contato-form button').on('click', function (e) {
        e.preventDefault();
        validateFormContato();
    });

    $("#contato-form").on('submit', function (e) {
        e.preventDefault();
        validateFormContato();
    });

    $('a.page-scroll').bind('click', function (event) {
        var anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $(anchor.attr('href')).offset().top - 60
        }, 1000, 'easeInOutExpo');
        event.preventDefault();
    });

    //Validar registro de novo usuário
    $("#modal-register button.btn-complete").on('click', function (e) {
        e.preventDefault();
        $.post($('#register-form').data('validation-url'), $('#register-form').serializeArray())
            .done(function (data, textStatus, jqXHR) {
                $('#register-form').submit();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError($('#register-form'), jqXHR.responseJSON);
                } else {
                    showFormValidationError($('#register-form'));
                }
            });
    });

    //Validar login
    $("#modal-access button.btn-complete").on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $.post($('#login-form').data('validation-url'), $('#login-form').serializeArray())
            .done(function (data, textStatus, jqXHR) {
                $('#login-form').submit();
                // console.log(data);
                window.location.href = $('#login-form').attr('action');
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError($('#login-form'), jqXHR.responseJSON);
                } else {
                    showFormValidationError($('#login-form'));
                }
            });
    });

    //Recuperar senha
    $("#modal-forgot button.btn-complete").on('click', function (e) {
        e.preventDefault();
        $.post($('#forgot-form').data('validation-url'), $('#forgot-form').serializeArray())
            .done(function (data, textStatus, jqXHR) {
                $('#modal-forgot .form').hide();
                $("#modal-forgot .success").show();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError($('#forgot-form'), jqXHR.responseJSON);
                } else {
                    showFormValidationError($('#forgot-form'));
                }
            });
    });

    //Adicionar background no navbar
    if ($(window).scrollTop() > 0) {
        $('#nav-menu').removeClass('transparent');
    }
    $(window).on('scroll', function () {
        if ($(window).scrollTop() == 0) {
            $('#nav-menu').addClass('transparent');
        } else {
            $('#nav-menu').removeClass('transparent');
        }
    });

    //Efeitos nos itens da página
    $('div.panel').addClass('invisible').viewportChecker({
        classToAdd: 'slideInRight animated', // Class to add to the elements when they are visible,
        classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
        classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
        offset: ['5%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
        invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
        repeat: false, // Add the possibility to remove the class if the elements are not visible
        scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
    });

    $('#mensalidade form').addClass('invisible').viewportChecker({
        classToAdd: 'slideInLeft animated', // Class to add to the elements when they are visible,
        classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
        classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
        offset: ['10%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
        invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
        repeat: false, // Add the possibility to remove the class if the elements are not visible
        scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
    });

    $('section a').addClass('invisible').viewportChecker({
        classToAdd: 'zoomIn animated', // Class to add to the elements when they are visible,
        classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
        classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
        offset: ['10%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
        invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
        repeat: false, // Add the possibility to remove the class if the elements are not visible
        scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
    });

    $('section h1, .banner-text').addClass('invisible').viewportChecker({
        classToAdd: 'fadeInDown animated', // Class to add to the elements when they are visible,
        classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
        classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
        offset: ['5%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
        invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
        repeat: false, // Add the possibility to remove the class if the elements are not visible
        scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
    });

    $('#contato form').addClass('invisible').viewportChecker({
        classToAdd: 'slideInLeft animated', // Class to add to the elements when they are visible,
        classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
        classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
        offset: ['10%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
        invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
        repeat: false, // Add the possibility to remove the class if the elements are not visible
        scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
    });

    $('#mensalidade-box, .fb-page').addClass('invisible').viewportChecker({
        classToAdd: 'slideInUp animated', // Class to add to the elements when they are visible,
        classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
        classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
        offset: ['10%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
        invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
        repeat: false, // Add the possibility to remove the class if the elements are not visible
        scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
    });

    $('#como-funciona .card').addClass('invisible').viewportChecker({
        classToAdd: 'flipInY animated', // Class to add to the elements when they are visible,
        classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
        classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
        offset: ['30%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
        invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
        repeat: false, // Add the possibility to remove the class if the elements are not visible
        scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
    });

    $('.form .form-control').on('focus', function () {
        $(this).parent().addClass('focused');
    });
    $('.form .form-control').on('blur', function () {
        $(this).parent().removeClass('focused');
    });
    $('[data-toggle="tooltip"]').tooltip();
});


function validateFormContato() {
    var formData = $('#contato-form').serializeArray();
    $.post($('#contato-form').data('validation-url'), formData)
        .done(function (data, textStatus, jqXHR) {
            sendContato()
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 422) {
                //noinspection JSUnresolvedVariable
                showFormValidationError($('#contato-form'), jqXHR.responseJSON);
            } else {
                showFormValidationError($('#contato-form'));
            }
        });
}

function sendContato() {
    var formData = $('#contato-form').serializeArray();
    $.post($('#contato-form').data('url'), formData)
        .done(function (data, textStatus, jqXHR) {
            showModalSuccess(data);
            $('#contato-form')[0].reset();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 422) {
                //noinspection JSUnresolvedVariable
                showFormValidationError($('#contato-form'), jqXHR.responseJSON);
            } else {
                showFormValidationError($('#contato-form'));
            }
        });
}

function showModalSuccess(text){
    $('#modal-success').find('#text').html(text);
    $('#modal-success').modal('show');
}

function validateChatInfo() {
    if (!nome || !email || !assunto) {
        alert('É necessário preencher todos os campos');
        return false;
    }
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(email)) {
        alert('E-mail inválido');
        return false;
    }
    return true;
}

function openChatWindow() {
    $('#chat-window').show()
}
function loginChat() {
    if (!validateChatInfo()) {
        return false;
    }
    $.post($('#chat-window').data('register-chat-url'), {
        nome: nome,
        email: email,
        assunto: assunto
    }).done(function (data) {
        chatId = data.id;
        $('#information').hide();
        $('#messages').show();
        updateInterval = setInterval(updateMessages, 3000);
    }).fail(function () {
    });
}

function sendMessage() {

    $.post($('#chat-window').data('send-message-url'), {
        mensagem: $('#messages textarea').val(),
        id_referencia: chatId
    }).done(function (data) {
        if (data.html !== undefined) {
            $('#messages .message-box').append(data.html);
        }
        $('#messages .message-box').scrollTop($('#messages .message-box')[0].scrollHeight);
        $('#messages textarea').val(null)
    }).fail(function () {
    });
    $('#messages textarea').val(null)
}

function updateMessages() {
    if (!$('#messages').is(':visible')) {
        clearInterval(updateInterval);
        return false;
    }
    if (updateAjax !== null) {
        updateAjax.abort();
    }
    updateAjax = $.post($('#chat-window').data('update-chat-url'), {
        chatId: chatId,
        lastMessageId: lastMessageId
    }).done(function (data) {
        $('#messages .message-box').append(data.html);
        if (data.status == 'ativo') {
            $('#messages textarea, #messages .btn-primary').prop('disabled', false);
        }
        if (data.status == 'fechado') {
            clearInterval(updateInterval);
        }
        if (data.lastMessageId) {
            lastMessageId = data.lastMessageId;
        }
        $('#messages .message-box').scrollTop($('#messages .message-box')[0].scrollHeight);
    }).fail(function () {
    });
}

function closeChatWindow() {
    $('#chat-window #information form')[0].reset();
    $('#chat-window #information').show();
    $('#chat-window #messages').hide();
    $('#chat-window').hide();
}