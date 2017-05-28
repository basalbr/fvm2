function showFormValidationError(form, errors) {
    if (!errors) {
        errors = [["Ocorreu um erro interno, por favor atualize a página e tente novamente."]];
    }
    var alertDiv = form.find('div.alert');
    alertDiv.on('animationend', function () {
        $(this).removeClass('animated shake')
    });
    alertDiv.empty()
    form.find('.form-group.alert-warning').removeClass('alert-warning');
    for (var i in errors) {
        if (typeof errors[i] === Array) {
            alertDiv.append('<p>' + errors[i][0] + '</p>');
        } else {
            alertDiv.append('<p>' + errors[i] + '</p>');
        }
        form.find('[name="' + i + '"]').parent().addClass('alert-warning');
    }
    alertDiv.show().addClass('animated shake');
    $('.modal, html, body').animate({
        scrollTop: alertDiv.offset().top - 50
    }, 500);

}

function showModalValidationError(errors) {
    if (!errors) {
        errors = [["Ocorreu um erro interno, por favor atualize a página e tente novamente."]];
    }
    var message = $('#modal-alert').find('.message');

    message.empty()
    for (var i in errors) {
        if (typeof errors[i] === Array) {
            message.append('<p>' + errors[i][0] + '</p>');
        } else {
            message.append('<p>' + errors[i] + '</p>');
        }
    }
    $('#modal-alert').modal('show');
}

// masks
var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 0 0000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function (val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        },
        clearIfNotMatch: true,
        placeholder: "(__)____-____"
    };


$(function () {
    $('.phone-mask').mask(SPMaskBehavior, spOptions);
    $('.date-mask').mask('00/00/0000', {clearIfNotMatch: true, placeholder: "__/__/____"});
    $('.time-mask').mask('00:00:00', {clearIfNotMatch: true});
    $('.number-mask').mask('#', {clearIfNotMatch: true});
    $('.date-time-mask').mask('00/00/0000 00:00:00', {clearIfNotMatch: true});
    $('.cep-mask').mask('00000-000', {clearIfNotMatch: true});
    $('.cpf-mask').mask('000.000.000-00', {reverse: true, clearIfNotMatch: true, placeholder: "___.___.___-__"});
    $('.cnpj-mask').mask('00.000.000/0000-00', {reverse: true}, {clearIfNotMatch: true});
    $('.money-mask').mask("#.##0,00", {reverse: true});
    $('.cnae-mask').mask('0000-0/00',{clearIfNotMatch: true, placeholder: '____-_/__'});
    $('.pis-mask').mask('999.99999.99-9',{clearIfNotMatch: true, placeholder: '___._____.__-_'});

    ///////////////abrir modal////////////////////////
    $('.open-modal').on('click', function (e) {
        e.preventDefault();
        $($(this).data('modal')).modal('show');
    });
});

