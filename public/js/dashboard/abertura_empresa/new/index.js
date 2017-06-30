$(function () {
    $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
        e.preventDefault();
        validateFormPrincipal();
    });

});

function checkSocioPrincipal() {
    var countSocios = 0;
    $('#form-principal').find("[name*='principal']").each(function () {
        if ($(this).val() === '1') {
            countSocios++;
        }
    });
    if(countSocios === 1){
        return true;
    }
    if(countSocios > 1){
        showFormValidationError($('#form-principal'), ['A empresa deve possuir somente um sócio principal. Você cadastrou '+countSocios]);
        return false
    }
    showFormValidationError($('#form-principal'), ['É necessário ter um sócio principal cadastrado.']);
    return false;
}

function validateFormPrincipal() {
    if (checkSocioPrincipal()) {
        var formData = $('#form-principal').serializeArray();
        $.post($('#form-principal').data('validation-url'), formData)
            .done(function (data, textStatus, jqXHR) {
                $('#form-principal').submit();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError($('#form-principal'), jqXHR.responseJSON);
                } else {
                    showFormValidationError($('#form-principal'));
                }
            });
    }

}
