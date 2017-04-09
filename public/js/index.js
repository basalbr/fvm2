$(function () {

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
        $.post($('#login-form').data('validation-url'), $('#login-form').serializeArray())
            .done(function (data, textStatus, jqXHR) {
                $('#login-form').submit();
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

    //Fix para lentidão nas animações causadas pelo plugin do facebook
    setTimeout(function () {
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    }, 1200);

    //Adicionar background no navbar
    if ($("body").scrollTop() > 0) {
        $('#nav-menu').removeClass('transparent');
    }
    $(window).on('scroll', function () {
        if ($("body").scrollTop() == 0) {
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

    $('.form .form-control').on('focus', function () {
        $(this).parent().addClass('focused');
    });
    $('.form .form-control').on('blur', function () {
        $(this).parent().removeClass('focused');
    });

});

