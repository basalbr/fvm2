/*
 Funcionalidades do modal de dependentes
 */
var dependenteId = 0;
$(function () {

    //Ao clicar em adicionar ou salvar dependente
    $('#modal-dependente').find('.btn-success').on('click', function () {
        var dependenteData = $('#modal-dependente').find('form').serializeArray();
        //remove referências caso seja uma edição
        $("[name^='dependentes[" + $(this).data('id') + "]'], tr[data-id='" + $(this).data('id') + "']").remove();
        validateDependente(dependenteData);
    });

    //editar dependente
    $('#list-dependentes').on('click', '.edit-dependente', function (e) {
        e.preventDefault();
        var id = parseInt($(this).data('id'));
        editDependente(id);
    }).on('click', '.remove-dependente', function (e) {
        e.preventDefault();
        var id = parseInt($(this).data('id'));
        $('#dependente-name').text($("input[name='dependentes[" + id + "][nome]']").val());
        $('#modal-remove-dependente').find('.btn-danger').data('id', id);
        $('#modal-remove-dependente').modal('show');
    });

    //remover dependente
    $('#modal-remove-dependente').find('.btn-danger').on('click', function (e) {
        e.preventDefault();
        $('#modal-remove-dependente').modal('hide');
        removeDependente($(this).data('id'));
    });

    $('#modal-dependente').on('hide.bs.modal', function (e) {
        resetDependenteModal();
    });
});

//editar informações de um dependente
function editDependente(id) {
    $('#modal-dependente').find('.btn-success').html('<i class="fa fa-save"></i> Alterar').data('id', id);
    //busca no form de dependente pelas partes equivalentes das informaçoes que estamos editando
    $("[name^='dependentes[" + id + "]']").each(function () {
        var name = $(this).attr('name');
        var value = $(this).val();
        name = name.replace('dependentes[' + id + '][', '');
        name = name.replace(']', '');
        if (name === 'id_tipo_dependencia') {
            $('#modal-dependente').find('select[name="' + name + '"] option').each(function () {
                if ($(this).val() === value) {
                    $(this).prop('selected', true);
                }
            });
        }
        $('#modal-dependente').find('input[name="' + name + '"]').val($(this).val());
    });
    $('#modal-dependente').modal('show');
}

//remove um dependente do formulário e da lista de dependentes
function removeDependente(id) {
    $("[name^='dependentes[" + id + "]'], tr[data-id='" + id + "']").remove();
    //se nenhum dependente estiver cadastrado, mostra tr indicando que nenhum dependente foi cadastrado
    if ($('#list-dependentes').find('tr').length === 1) {
        $("#list-dependentes").find('.none').show();
    }
}

//Adiciona um novo dependente na tabela e no formulário
function addDependente(dependenteData, id) {
    dependenteId++;
    if (!id) {
        id = dependenteId;
    }
    var dependenteName;

    for (var i in dependenteData) {
        if (dependenteData[i].name === 'nome') {
            dependenteName = dependenteData[i].value;
        }

        $('#form-principal').append($('<input>').attr({
            "name": "dependentes[" + id + "][" + dependenteData[i].name + "]",
            "type": "hidden",
            "value": dependenteData[i].value
        }));
    }
    var dependenteTr = $('<tr>').attr('data-id', id);
    var dependenteEditButton = $('<button>').addClass('btn btn-warning edit-dependente').attr('data-id', id).text(' Editar').prepend($('<i>').addClass('fa fa-edit'));
    var dependenteRemoveButton = $('<button>').addClass('btn btn-danger remove-dependente').attr('data-id', id).text(' Remover').prepend($('<i>').addClass('fa fa-remove'));
    var dependenteButtons = $('<td>');
    dependenteButtons.append(dependenteEditButton);
    dependenteButtons.append(dependenteRemoveButton);
    dependenteTr.append($('<td>').text(dependenteName));
    dependenteTr.append($('<td>').append(dependenteButtons));
    $('#list-dependentes').append(dependenteTr).find('.none').hide();
    $('#modal-dependente').find('form')[0].reset();
    $('#modal-dependente').modal('hide');
}

function validateDependente(dependenteData) {
    $.post($('#modal-dependente').find('form').data('validation-url'), dependenteData)
        .done(function (data, textStatus, jqXHR) {
            addDependente(dependenteData);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 422) {
                //noinspection JSUnresolvedVariable
                showFormValidationError($('#modal-dependente').find('form'), jqXHR.responseJSON);
            } else {
                showFormValidationError($('#modal-dependente').find('form'));
            }
        });
}

function resetDependenteModal() {
    $('#modal-dependente').find('.alert-warning').removeClass('alert-warning alert');
    $('#modal-dependente').find('form')[0].reset();
    $('#modal-dependente').find('.btn-success').html('<i class="fa fa-plus"></i> Adicionar Dependente').data('id', null);
    $('#modal-dependente').find('.alert-danger').hide();
}