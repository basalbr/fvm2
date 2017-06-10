$(function () {
    $('.deficiencia-checkbox').on('change', function () {
        var idDeficiencia = $(this).data('id')
        if ($(this).is(':checked')) {
            $('#form-principal').append($('<input>').attr({
                type: 'hidden',
                value: idDeficiencia,
                name: 'deficiencias[][id_tipo_deficiencia]'
            }));
        } else {
            $('[name*="deficiencias[]"][value="' + idDeficiencia + '"]').remove();
        }
    })
});
