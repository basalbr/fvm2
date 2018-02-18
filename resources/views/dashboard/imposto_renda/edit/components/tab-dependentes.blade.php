@section('js')
    @parent
    <script type="text/javascript">
        var dependenteId = 0;
        $(function () {
            $('.lista-dependentes .existente').each(function () {
                $('.lista-dependentes .none').hide();
                if (parseInt($(this).data('id')) > dependenteId) {
                    dependenteId = parseInt($(this).data('id'));
                }
            });
            //Ao clicar em adicionar ou salvar dependente
            $('#modal-dependente').find('.btn-success').on('click', function () {
                var dependenteData = $('#modal-dependente').find('form').serializeArray();
                var depId = $(this).data('id') !== undefined ? parseInt($(this).data('id')) : false;
                //remove referências caso seja uma edição
                $("[name^='dependentes[" + $(this).data('id') + "]'], tr[data-id='" + $(this).data('id') + "']").remove();
                validateDependente(dependenteData, depId);
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
            $('#modal-dependente .modal-footer').find('.btn-success').html('<i class="fa fa-save"></i> Alterar').data('id', id);
            //busca no form de dependente pelas partes equivalentes das informaçoes que estamos editando
            $("[name^='dependentes[" + id + "]']").each(function () {
                var name = $(this).attr('name');
                var value = $(this).val();
                name = name.replace('dependentes[' + id + '][', '');
                name = name.replace(']', '');
                if (name === 'id_ir_tipo_dependente') {
                    $('#modal-dependente').find('select[name="' + name + '"] option').each(function () {
                        if ($(this).val() === value) {
                            $(this).prop('selected', true);
                        }
                    });
                }
                if (name === 'cpf' || name === 'rg') {
                    addLinkRow(name, value, true);
                }
                if (name.indexOf('anexos') > -1 && name.indexOf('descricao') > -1) {
                    name = name.replace('anexos', '[anexos]');
                    var filename = $('[name="dependentes[' + id + ']' + name.replace('[descricao]', '[arquivo]') + '"]').val();
                    addRow(value, filename, true);
                }
                if (name.indexOf('remover') > -1) {
                    name = name.replace('remover', '[remover]');
                    $('#modal-dependente form').append('<input type="hidden" name="'+name+'" value="'+value+'">');
                }
                $('#modal-dependente').find('input[name="' + name + '"]').val($(this).val());
                refreshLinkButtons(true);
            });
            $('[name="dep_docs' + id + '[]"]').each(function () {
                var data_link = $(this).data('link') !== undefined ? 'data-link="' + $(this).data('link') + '"' : '';
                $('#modal-dependente .lista_documentos_enviados').append('<tr ' + data_link + ' data-anexo="' + $(this).data('id') + '"><td>' + $(this).val() + '</td><td><a class="btn-danger btn"><i class="fa fa-remove"></i> Excluir</a></td></tr>');
            });
            refreshDocsCount(true);
            refreshLinkButtons(true);
            $('#modal-dependente').modal('show');
            $('#modal-dependente .modal-footer').find('.btn-success').html('<i class="fa fa-save"></i> Alterar').data('id', id);
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
                var save = false;
                if (dependenteData[i].name === 'nome') {
                    dependenteName = dependenteData[i].value;
                }
                var singleNames = ['nome', 'id_ir_tipo_dependente', 'cpf', 'data_nascimento', 'titulo_eleitor', 'rg'];
                var name = dependenteData[i].name.replace('[', '][');
                if (name.indexOf('remover') > -1) {
                    console.log('[name="dep_docs' + id + '[]"]')
                    console.log('tem que remover ' + dependenteData[i].value);
                    $('[name="dep_docs' + id + '[]"]').each(function () {
                        console.log(parseInt($(this).data('id')));
                        console.log(id);
                        if (parseInt($(this).data('id')) == dependenteData[i].value) {
                            $(this).remove();
                        }
                    });
                }
                if (singleNames.indexOf(name) > -1) {
                    name = '[' + name + ']';
                    save = true;
                } else if (name.indexOf('anexos') > -1 || name.indexOf('remover') > -1) {
                    name = name.substr(1);
                    save = true;
                }
                if (save) {
                    $('#form-principal').append($('<input>').attr({
                        "name": "dependentes[" + id + "]" + name,
                        "type": "hidden",
                        "value": dependenteData[i].value
                    }));
                }
            }
            var dependenteTr = $('<tr>').attr('data-id', id);
            var dependenteEditButton = $('<button>').addClass('btn btn-warning edit-dependente').attr('data-id', id).text(' Editar').prepend($('<i>').addClass('fa fa-edit'));
            var dependenteRemoveButton = $('<button>').addClass('btn btn-danger remove-dependente').attr('data-id', id).text(' Remover').prepend($('<i>').addClass('fa fa-remove'));
            var dependenteButtons = $('<td>');
            dependenteButtons.append(dependenteEditButton);
            dependenteButtons.append(dependenteRemoveButton);
            dependenteTr.append($('<td>').text(dependenteName));
            dependenteTr.append(dependenteButtons);
            $('#list-dependentes').append(dependenteTr).find('.none').hide();
            $('#modal-dependente').find('form')[0].reset();
            $('#modal-dependente').modal('hide');
        }

        function validateDependente(dependenteData, depId) {
            $.post($('#modal-dependente').find('form').data('validation-url'), dependenteData)
                .done(function (data, textStatus, jqXHR) {
                    addDependente(dependenteData, depId);
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
            $('#modal-dependente .modal-footer').find('.btn-success').html('<i class="fa fa-check"></i> Adicionar dependente e documentos').data('id', null);
            $('#modal-dependente .tab-content').nextAll('[type="hidden"]').remove();
            $('#modal-dependente .lista_documentos_enviados').find('tr').not('.none').remove();
            $('#modal-dependente .lista_documentos_enviados').find('.none').show();
            $('#modal-dependente').find('.alert-danger').hide();
            refreshLinkButtons(true);
            refreshDocsCount(true);
        }
    </script>
@stop

<div role="tabpanel" class="tab-pane animated fadeIn" id="tab-dependentes">
    <div class="form-section">
        <p class="alert-info alert" style="display: block"><strong>Dependentes:</strong> Cadastre seus dependentes e
            envie os documentos necessários.</p>
        <div class="col-xs-12">
            <table class="table  table-striped table-hover">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="list-dependentes" class="lista-dependentes">
                <tr class="none">
                    <td colspan="2">Nenhum dependente declarado</td>
                </tr>
                @foreach($ir->dependentes as $dependente)
                    <tr data-id="{{$dependente->id}}" class="existente">
                        <td>{{$dependente->nome}}</td>
                        <td>
                            <button class="btn btn-warning edit-dependente" data-id="{{$dependente->id}}"><i
                                        class="fa fa-edit"></i> Editar
                            </button>
                            <button class="btn btn-danger remove-dependente" data-id="{{$dependente->id}}"><i
                                        class="fa fa-remove"></i> Excluir
                            </button>
                        </td>
                    </tr>
                    <input type="hidden" name="dependentes[{{$dependente->id}}][nome]" value="{{$dependente->nome}}"/>
                    <input type="hidden" name="dependentes[{{$dependente->id}}][data_nascimento]"
                           value="{{$dependente->data_nascimento->format('d/m/Y')}}"/>
                    <input type="hidden" name="dependentes[{{$dependente->id}}][id_ir_tipo_dependente]"
                           value="{{$dependente->id_ir_tipo_dependente}}"/>
                    @foreach($dependente->anexos as $anexo)
                        @if(strtolower($anexo->descricao) == 'rg' || strtolower($anexo->descricao) == 'cpf')
                            <input type="hidden" data-link="{{strtolower($anexo->descricao)}}"
                                   data-dep-id="{{$dependente->id}}" name="dep_docs{{$dependente->id}}[]"
                                   value="{{$anexo->descricao}}" data-id="{{$anexo->id}}"/>
                        @else
                            <input type="hidden" data-dep-id="{{$dependente->id}}" name="dep_docs{{$dependente->id}}[]"
                                   value="{{$anexo->descricao}}" data-id="{{$anexo->id}}"/>
                        @endif
                    @endforeach
                @endforeach

                </tbody>
            </table>
            <button type="button" class="btn btn-primary open-modal" data-modal="#modal-dependente"><span
                        class="fa fa-user-plus"></span>
                Adicionar Dependente
            </button>
        </div>
        <div class="clearfix"></div>
    </div>
</div>