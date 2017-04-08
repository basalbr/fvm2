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
    $('.phone').mask(SPMaskBehavior, spOptions);
    $('.date').mask('00/00/0000', {clearIfNotMatch: true, placeholder: "__/__/____"});
    $('.time').mask('00:00:00', {clearIfNotMatch: true});
    $('.date_time').mask('00/00/0000 00:00:00', {clearIfNotMatch: true});
    $('.cep').mask('00000-000', {clearIfNotMatch: true});
    $('.cpf').mask('000.000.000-00', {reverse: true, clearIfNotMatch: true, placeholder: "__/__/____"});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true}, {clearIfNotMatch: true});
    $('.money').mask("#.##0,00", {reverse: true});
});
