@extends('admin.layouts.master')

@section('top-title')
    Cadastros <i class="fa fa-angle-right"></i> <a href="{{route('listCadastroAlteracao')}}">Alterações</a> <i
            class="fa fa-angle-right"></i> {{$alteracao->descricao}}
@stop
@section('js')
    @parent
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=xs6j8xeombkhwcowbftixwvy24erlvylumyoad8shqc46c98"></script>
    <script type="text/javascript">
        var key = 0;
        $(function () {
            $('[name="campo_tipo"]').on('change', function () {
                checkTableFields($(this).val() == 'table');
            });
            $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });

            $('#fields-table').on('click', '.btn-danger', function () {
                removeField($(this));
            });
            $('#add-field').on('click', function () {
                if (validateField()) {
                    addField();
                } else {
                    alert('Complete todos os campos')
                }
            });
            showNothingToDisplayMessage();
        });

        function validateFormPrincipal() {
            var formData = new FormData();
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

        function validateField() {
            if ($('[name="campo_nome"]').val() == '' || $('[name="campo_descricao"]').val() == '') {
                return false;
            }
            return true;
        }

        function addField() {
            $('select[name^="campo_"], input[name^="campo_"]').each(function () {
                $('#form-principal').append('<input type="hidden" name="campos[' + key + '][' + $(this).attr('name').replace('campo_', '') + ']" value="' + $(this).val() + '"/>');
            });
            var tipo_descricao = $("[name='campo_tipo'] option:selected").attr('value') == 'table' ? 'Tabela (' + $("[name='campo_tabela']").val() + ', ' + $("[name='campo_tabela']").val() + ')' : $("[name='campo_tipo'] option:selected").text();
            var obrigatorio = parseInt($("[name='campo_obrigatorio']").val()) === 1 ? 'Sim' : 'Não';
            $('#fields-table').append('<tr><td>' + $("[name='campo_nome']").val() + '</td><td>' + $("[name='campo_descricao']").val() + '</td><td>' + tipo_descricao + '</td><td>' + obrigatorio + '</td><td><button class="btn btn-danger" data-key="' + key + '"><i class="fa fa-remove"></i></button</td></tr>');
            $('input[name^="campo_"]').val('');
            key++;
            showNothingToDisplayMessage();
        }

        function removeField(element) {
            if (element.data('id') !== undefined) {
                console.log(element.data('id'))
                $('#form-principal').append('<input type="hidden" name="deletar[]" value="' + element.data('id') + '">');
            } else {
                $('input[name^="campos[' + element.data('key') + ']"]').remove();
            }
            element.parent().parent().remove();
            showNothingToDisplayMessage();
        }

        function showNothingToDisplayMessage() {
            $('tbody tr').length > 1 ? $('tbody .nenhum').hide() : $('tbody .nenhum').show();
        }

        function checkTableFields(table) {
            if (table) {
                $('[name="campo_tabela"], [name="campo_coluna"]').val(null).parent().show();
            } else {
                $('[name="campo_tabela"], [name="campo_coluna"]').val(null).parent().hide();
            }
        }

    </script>
@stop
@section('content')
    <div class="tab-content">
        <form class="form" method="POST" action="" id="form-principal"
              data-validation-url="{{route('validateTipoAlteracao')}}" enctype="multipart/form-data">
            <div role="tabpanel" class="active tab-pane animated fadeIn" id="todo">
                <div class="col-xs-12">
                    <h3>Informações</h3>
                </div>
                @include('admin.components.form-alert')
                @include('admin.components.disable-auto-complete')
                {{csrf_field()}}
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Descrição *</label>
                        <input class="form-control" name="descricao" value="{{$alteracao->descricao}}"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Valor *</label>
                        <input class="form-control money-mask" name="valor" value="{{$alteracao->getValor()}}"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Tipo Desconto Progressivo *</label>
                        <select class="form-control" name="tipo_desconto_progressivo">
                            <option value="percentual" {{$alteracao->tipo_desconto_progressivo == 'percentual' ? 'selected' : ''}}>
                                Percentual
                            </option>
                            <option value="fixo" {{$alteracao->tipo_desconto_progressivo == 'fixo' ? 'selected' : ''}}>
                                Fixo
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Valor Desconto Progressivo *</label>
                        <input class="form-control money-mask" name="valor_desconto_progressivo"
                               value="{{$alteracao->getValorDescontoProgressivo()}}"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <h3>Campos</h3>
                </div>
                <div class="col-xs-12"><p>Complete os campos abaixo e clique em "Adicionar" para adicionar o campo</p>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12">
                    <div class="form-inline">
                        <div class="form-group">
                            <label>Nome</label>
                            <input name="campo_nome" style="width: 300px" class="form-control" value=""
                                   autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label>Descrição</label>
                            <input name="campo_descricao" style="width: 300px" class="form-control" value=""
                                   autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label>Tipo</label>
                            <select name="campo_tipo" style="width: 300px" class="form-control">
                                <option value="string">Campo de texto</option>
                                <option value="file">Arquivo</option>
                                <option value="textarea">Área de texto</option>
                                <option value="table">Tabela</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Obrigatório?</label>
                            <select name="campo_obrigatorio" style="width: 300px" class="form-control">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group animated fadeIn" style="display: none">
                            <label>Tabela</label>
                            <input name="campo_tabela" style="width: 300px" class="form-control" value=""/>
                        </div>
                        <div class="form-group animated fadeIn" style="display: none">
                            <label>Coluna</label>
                            <input name="campo_coluna" style="width: 300px" class="form-control" value=""/>
                        </div>
                        <div class="clearfix"></div>
                        <button type="button" class="btn btn-primary" id="add-field"><i class="fa fa-plus"></i>
                            Adicionar
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr>
                <div class="col-xs-12">
                    <table class="table table-hovered table-striped">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Tipo</th>
                            <th>Obrigatório</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="fields-table">
                            @foreach($alteracao->getCamposAtivos() as $campo)
                                <tr>
                                    <td>{{$campo->nome}}</td>
                                    <td>{{$campo->descricao}}</td>
                                    <td>{{$campo->getTipoDescricao()}}</td>
                                    <td>{{$campo->obrigatorio ? 'Sim' : 'Não'}}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-id="{{$campo->id}}"><i
                                                    class="fa fa-remove"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="nenhum animated fadeIn">
                                <td colspan="5">Nenhum campo cadastrado</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="navigation-options">
                <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
            </div>
        </form>
    </div>
@stop