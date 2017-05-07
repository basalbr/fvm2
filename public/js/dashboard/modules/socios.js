/*
 Funcionalidades do modal de sócios
 */
var socioId = 0;
$(function () {

    //Ao clicar em adicionar ou salvar sócio
    $('#modal-socio').find('.btn-success').on('click', function () {
        var socioData = $('#modal-socio').find('form').serializeArray();
        //remove referências caso seja uma edição
        $("[name^='socios[" + $(this).data('id') + "]'], tr[data-id='" + $(this).data('id') + "']").remove();
        validateSocio(socioData);
    });

    //editar sócio
    $('#list-socios').on('click', '.edit-socio', function (e) {
        e.preventDefault();
        var id = parseInt($(this).data('id'));
        editSocio(id);
    }).on('click', '.remove-socio', function (e) {
        e.preventDefault();
        var id = parseInt($(this).data('id'));
        $('#socio-name').text($("input[name='socios[" + id + "][nome]']").val());
        $('#modal-remove-socio').find('.btn-danger').data('id', id);
        $('#modal-remove-socio').modal('show');
    });

    //remover sócio
    $('#modal-remove-socio').find('.btn-danger').on('click', function (e) {
        e.preventDefault();
        $('#modal-remove-socio').modal('hide');
        removeSocio($(this).data('id'));
    });

    $('#modal-socio').on('hide.bs.modal', function (e) {
        resetSocioModal();
    });
});

//editar informações de um sócio
function editSocio(id) {
    $('#modal-socio').find('.btn-success').html('<i class="fa fa-save"></i> Alterar').data('id', id);
    //busca no form de sócio pelas partes equivalentes das informaçoes que estamos editando
    $("[name^='socios[" + id + "]']").each(function () {
        var name = $(this).attr('name');
        var value = $(this).val();
        name = name.replace('socios[' + id + '][', '');
        name = name.replace(']', '');
        if (name === 'principal' || name === 'estado_civil' || name === 'regime_casamento' || name === 'id_uf') {
            $('#modal-socio').find('select[name="' + name + '"] option').each(function () {
                if ($(this).val() === value) {
                    $(this).prop('selected', true);
                }
            });
        }
        $('#modal-socio').find('input[name="' + name + '"]').val($(this).val());
    });
    $('#modal-socio').modal('show');
}

//remove um sócio do formulário e da lista de sócios
function removeSocio(id) {
    $("[name^='socios[" + id + "]'], tr[data-id='" + id + "']").remove();
    //se nenhum sócio estiver cadastrado, mostra tr indicando que nenhum sócio foi cadastrado
    if ($('#list-socios').find('tr').length === 1) {
        $("#list-socios").find('.none').show();
    }
}

//Adiciona um novo sócio na tabela e no formulário
function addSocio(socioData, id) {
    socioId++;
    if (!id) {
        id = socioId;
    }
    var socioName;
    var socioPrincipal = 0;
    for (var i in socioData) {
        if (socioData[i].name === 'nome') {
            socioName = socioData[i].value;
        }
        if (socioData[i].name === 'principal') {
            socioPrincipal = socioData[i].value;
        }
        $('#form-principal').append($('<input>').attr({
            "name": "socios[" + id + "][" + socioData[i].name + "]",
            "type": "hidden",
            "value": socioData[i].value
        }));
    }
    var socioTr = $('<tr>').attr('data-id', id);
    var socioEditButton = $('<button>').addClass('btn btn-warning edit-socio').attr('data-id', id).text(' Editar').prepend($('<i>').addClass('fa fa-edit'));
    var socioRemoveButton = $('<button>').addClass('btn btn-danger remove-socio').attr('data-id', id).text(' Remover').prepend($('<i>').addClass('fa fa-remove'));
    var socioButtons = $('<td>');
    socioButtons.append(socioEditButton);
    socioButtons.append(socioRemoveButton);
    socioTr.append($('<td>').text(socioName));
    socioTr.append($('<td>').text(socioPrincipal > 0 ? 'Sim' : 'Não'));
    socioTr.append($('<td>').append(socioButtons));
    $('#list-socios').append(socioTr).find('.none').hide();
    $('#modal-socio').find('form')[0].reset();
    $('#modal-socio').modal('hide');
}

function validateSocio(socioData) {
    $.post($('#modal-socio').find('form').data('validation-url'), socioData)
        .done(function (data, textStatus, jqXHR) {
            addSocio(socioData);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 422) {
                //noinspection JSUnresolvedVariable
                showFormValidationError($('#modal-socio').find('form'), jqXHR.responseJSON);
            } else {
                showFormValidationError($('#modal-socio').find('form'));
            }
        });
}

function resetSocioModal() {
    $('#modal-socio').find('.alert-warning').removeClass('alert-warning alert');
    $('#modal-socio').find('form')[0].reset();
    $('#modal-socio').find('.btn-success').html('<i class="fa fa-plus"></i> Adicionar Sócio').data('id', null);
    $('#modal-socio').find('.alert-danger').hide();
}