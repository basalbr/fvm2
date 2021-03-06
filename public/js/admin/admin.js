var chat;

function notify(title, message, url) {
    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        var notification = new Notification(title, {
            icon: 'http://webcontabilidade.com/images/notificacao.png',
            body: message,
        });
        notification.onclick = function () {
            window.open(url);
        };
    }
}

function inicializaChatNotifications() {
    $.get($('body').data('chat-count-url'), function (data) {
        chat = data.total;
        setInterval(function () {
            $.get($('body').data('chat-notification-url'), function (data) {
                if (data.total != chat) {
                    chat = data.total;
                    notify(data.title, data.message, data.url);
                }
            });
        }, 15000);
    });
}

function askPermission() {
    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    }
}

$(function () {
    // inicializaChatNotifications();
    // askPermission();
});

function checkIfInView(element) {
    var offset = (element.offset().top + 50) - $('#left-menu').scrollTop();
    if (offset > window.innerHeight) {
        return false;
    }
    return true;
}

$(function () {
    if ($('#left-menu a.active').length) {
        $("#left-menu ul li ul a.active").parent().parent().addClass('open').parent();
        if (!checkIfInView($('#left-menu a.active'))) {
            $('#left-menu').animate({
                scrollTop: $("#left-menu a.active").offset().top + 100
            }, 0);
        }
    }
    $('#left-menu ul a').on('click', function (e) {
        if ($(this).parent().has('ul').length > 0) {
            e.preventDefault();
            $(this).toggleClass('open');
            $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
            $(this).next('ul').toggleClass('open');
        }
    });
    $('.form-control').on('focus', function () {
        $(this).parent().addClass('focused');
    });
    $('.form-control').on('blur', function () {
        $(this).parent().removeClass('focused');
    });
    $('.back').on('click', function (e) {
        e.preventDefault();
        $('.nav-tabs li.active').prev().find('a').tab('show');
    });
    $('.next').on('click', function (e) {
        e.preventDefault();
        $('.nav-tabs li.active').next().find('a').tab('show');
    });
    $('#open-left-menu').on('click', function (e) {
        e.preventDefault()
        $('#left-menu').toggleClass('open');
        $(this).toggleClass('active');
    });
    $('div').on('click','.copy-to-clipboard', function (e) {
        console.log('a');
        e.preventDefault();
        copyToClipboard($(this).parent());
    })
});

function showModalAlert(message) {
    $('#modal-alert').find('.message').text(message);
    $('#modal-alert').modal('show');
}

function showModalSuccess(message) {
    $('#modal-success').find('.message').text(message);
    $('#modal-success').modal('show');
}

function copyToClipboard(element) {
    originalText = element.text();
    element.text(element.text().replace(/[^0-9]/gi, ''));
    if (document.selection) {
        var range = document.body.createTextRange();
        range.moveToElementText(element);
        range.select().createTextRange();
        document.execCommand("copy");

    } else if (window.getSelection) {
        var selection =  window.getSelection();
        var range = document.createRange();
        range.selectNode(element[0]);
        selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand("copy");
    }
    element.html(originalText+'<button class="btn-link btn-xs copy-to-clipboard"><i class="fa fa-clipboard"></i></button>');
}
