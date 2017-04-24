//funcionalidades do modal de CNAES

$(function(){
    $('#modal-cnae').find('form').on('submit', function (e) {
        e.preventDefault();
        searchCnaeByDescription($('#cnae-description').val())
    });

    $('#list-cnaes').on('click', '.remove-cnae', function (e) {
        e.preventDefault();
        removeCnae($(this).data('code'));
    });

    $('#modal-cnae .list').on('click', '.add-cnae', function (e) {
        e.preventDefault();
        if ($('#list-cnaes').has('tr[data-code="' + $(this).data('code') + '"]').length) {
            showModalAlert('Este CNAE já foi adicionado');
        } else {
            addCnae($(this).data('code'), $(this).data('description'));
        }
    });

    $('#cnae-add-code').on('click', function () {
        var code = $('#cnae-code').val();
        if ($('#list-cnaes').has('tr[data-code="' + code + '"]').length) {
            showModalAlert('Este CNAE já foi adicionado');
        } else {
            searchCnaeByCode(code);
        }
    });

    $('#cnae-search').on('click', function () {
        searchCnaeByDescription($('#cnae-description').val());
    });

    $('#cnae-code').on('keypress', function (e) {
        if (e.keyCode === 13) {
            $('#cnae-add-code').click();
        }
    });

});

//Buscar CNAE por descrição
function searchCnaeByDescription(description) {
    $('#modal-cnae').find("[data-code]").remove();
    $.post($('#cnae-description').data('search-description-url'), {"description": description})
        .done(function (data, textStatus, jqXHR) {
            for (var i in data) {
                if (!$('#list-cnaes').has('tr[data-code="' + data[i].codigo + '"]').length) {
                    var cnaeTr = $('<tr>').attr('data-code', data[i].codigo);
                    var cnaeAddButton = $('<button>').addClass('btn btn-success add-cnae').attr({'data-code': data[i].codigo, 'data-description':data[i].descricao}).text(' Adicionar').prepend($('<i>').addClass('fa fa-plus'));
                    var cnaeButtons = $('<td>');
                    cnaeButtons.append(cnaeAddButton);
                    cnaeTr.append($('<td>').text(data[i].codigo));
                    cnaeTr.append($('<td>').text(data[i].descricao));
                    cnaeTr.append($('<td>').append(cnaeButtons));
                    $('#modal-cnae').find('.list').append(cnaeTr);
                }
            }
            $('#modal-cnae').find('.none').hide();

        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            $('#modal-cnae').find('.none').show();
        });
}

//Buscar CNAE por código
function searchCnaeByCode(code) {
    $.post($('#cnae-code').data('search-code-url'), {"code": code})
        .done(function (data, textStatus, jqXHR) {
            addCnae(data.codigo, data.descricao);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            //noinspection JSUnresolvedVariable
            if (jqXHR.responseJSON.code !== undefined) {
                showModalAlert(jqXHR.responseJSON.code[0]);
            } else {
                showModalAlert(jqXHR.responseJSON.message);
            }

        });
}

//remove um cnae do formulário e da lista de cnaes
function removeCnae(code) {
    $("input[value='" + code + "'], tr[data-code='" + code + "']").remove();
    //se nenhum sócio estiver cadastrado, mostra tr indicando que nenhum sócio foi cadastrado
    if ($('#list-cnaes').find('tr').length === 1) {
        $("#list-cnaes").find('.none').show();
    }
}

//Adicionar CNAE
function addCnae(code, description) {
    $('#form-principal').append($('<input>').attr({
        "name": "cnaes[]",
        "type": "hidden",
        "value": code
    }));
    var cnaeTr = $('<tr>').attr('data-code', code);
    var cnaeRemoveButton = $('<button>').addClass('btn btn-danger remove-cnae').attr('data-code', code).text(' Remover').prepend($('<i>').addClass('fa fa-remove'));
    var cnaeButtons = $('<td>');
    cnaeButtons.append(cnaeRemoveButton);
    cnaeTr.append($('<td>').text(description));
    cnaeTr.append($('<td>').text(code));
    cnaeTr.append($('<td>').append(cnaeButtons));
    $('#list-cnaes').append(cnaeTr).find('.none').hide();
    $('#cnae-code').val(null).focus();
}
