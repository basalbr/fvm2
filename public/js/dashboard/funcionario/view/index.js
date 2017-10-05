$(function () {
    $('[name="contrato[qtde_dias_experiencia]"], [name="contrato[qtde_dias_prorrogacao_experiencia]"]').on('keyup', function () {
        $('#data_inicio_experiencia').val($('[name="contrato[data_admissao]"]').val());
        var days = parseInt($('[name="contrato[qtde_dias_experiencia]"]').val()) + parseInt($('[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val());
        if (days > 90) {
            showModalAlert('A quantidade de dias de experiência não pode exceder 90.');
            $('#contrato-experiencia-info input').val(null);
        } else {
            calculateDaysOfExperience();
        }
    });

    if($('#experiencia').is(':checked')){
        calculateDaysOfExperience();
    }

    $('[name="contrato[sindicalizado]"]').on('change', function () {
        if ($(this).val() === '1') {
            $('#info-sindicato').show().find('input').prop('disabled', false);
        } else {
            $('#info-sindicato').hide().find('input').prop('disabled', true).val(null);
        }
    });

    $('#experiencia').on('change', function () {
        if ($(this).is(':checked')) {
            $("#contrato-experiencia-info").show().find('[name="contrato[qtde_dias_experiencia]"],[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val(45).prop('disabled', false);
            calculateDaysOfExperience();
        } else {
            $("#contrato-experiencia-info").hide().find('[name="contrato[qtde_dias_experiencia]"],[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val(null).prop('disabled', true);
        }
    });

    $('#tipo-cadastro').on('change', function () {
        $('#contrato-experiencia input[type="checkbox"]').prop('checked', false);
        $("#contrato-experiencia-info").hide().find('[name="contrato[qtde_dias_experiencia]"],[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val(null).prop('disabled', true);
        if ($(this).val() == 1) {
            $("#exame-admissional").show();
            $("#exame-admissional input").prop('disabled', false);
            $("#contrato-experiencia").show();
            $("#contrato-experiencia input[type='checkbox']").prop('disabled', false);

        } else {
            $("#exame-admissional").hide();
            $("#exame-admissional input").prop('disabled', true);
            $("#contrato-experiencia").hide();
            $("#contrato-experiencia input").prop('disabled', true);
        }
    });
    $('#estrangeiro').on('change', function () {
        if ($(this).val() == 1) {
            $("#info-estrangeiro").show();
            $("#info-estrangeiro input").prop('disabled', false)
        } else {
            $("#info-estrangeiro").hide();
            $("#info-estrangeiro input").prop('disabled', true)
        }
    });
    $('[name="contrato[data_admissao]"]').on('keyup', function () {
        $('#data_inicio_experiencia').val($(this).val());
        if ($(this).val().length == 10) {
            if (isValidDate($(this).val())) {
                calculateDaysOfExperience();
            } else {
                $(this).val(null);
                $('#contrato-experiencia-info input').val(null);
                showModalAlert('A data de admissão deve ser uma data válida, por exemplo: 01/01/2017')
            }
        }
    });

    $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
        e.preventDefault();
        validateFormPrincipal();
    });
});

function calculateDaysOfExperience() {

    if ($('#experiencia').is(':checked') && $('[name="contrato[data_admissao]"]').val().length == 10) {
        if (isValidDate($('[name="contrato[data_admissao]"]').val())) {
            var dataInicioExperiencia = parseStringToDate($('#data_inicio_experiencia').val());
            var qtdeDiasExperiencia = $('[name="contrato[qtde_dias_experiencia]"]').val() !== '' ? parseInt($('[name="contrato[qtde_dias_experiencia]"]').val()) : 0;
            var qtdeDiasProrrogacao = $('[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val() !== '' ? parseInt($('[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val()) : 0;
            $('#data_final_experiencia').val(parseDateToString(addDaysToDate(dataInicioExperiencia, qtdeDiasExperiencia)));
            var dataFinalExperiencia = parseStringToDate($('#data_final_experiencia').val());
            $('#data_inicio_prorrogacao').val(parseDateToString(addDaysToDate(dataFinalExperiencia, 2)));
            var dataInicioProrrogacao = parseStringToDate($('#data_inicio_prorrogacao').val());
            $('#data_final_prorrogacao').val(parseDateToString(addDaysToDate(dataInicioProrrogacao, qtdeDiasProrrogacao)));
        }
    }
}

function parseStringToDate(string) {
    try {
        var dsplit = string.split("/");
        return new Date(dsplit[2], dsplit[1] - 1, dsplit[0]);
    } catch (e) {
        throw (new Error('Formato de data inválido'));
    }
}

function addDaysToDate(date, days) {
    try {
        return new Date(date.setDate(date.getDate() + (days - 1)));
    } catch (e) {
        throw (new Error('Formato de data inválido'));
    }
}

function parseDateToString(date) {

    var month = (date.getMonth() + 1) < 10 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
    var day = date.getDate() < 10 ? "0" + date.getDate().toString() : date.getDate().toString();
    return day + '/' + month + '/' + date.getFullYear().toString();
}

function isValidDate(s) {
    var bits = s.split('/');
    var d = new Date(bits[2], bits[1] - 1, bits[0]);
    return d && (d.getMonth() + 1) == bits[1];
}

function validateFormPrincipal() {
    var formData = new FormData();
    if ($('[name="documentos[exame_admissional]"]').val() !== '' && $('[name="documentos[exame_admissional]"]').val() !== null) {
        formData.append('documentos[exame_admissional]', $('[name="documentos[exame_admissional]"]')[0].files[0])
    }
    var params = $('#form-principal').serializeArray();
    $(params).each(function (index, element) {
        formData.append(element.name, element.value);
    });
    $.post({
        url: $('#form-principal').data('validation-url'),
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data, textStatus, jqXHR) {
        $('#form-principal').submit();
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 422) {
            //noinspection JSUnresolvedVariable
            showFormValidationError($('#form-principal'), jqXHR.responseJSON);
        } else {
            showFormValidationError($('#form-principal'));
        }
    });
}