@extends('dashboard.layouts.master')

@section('js')
    @parent
    <script type="text/javascript">
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
            if (countSocios === 1) {
                return true;
            }
            if (countSocios > 1) {
                showFormValidationError($('#form-principal'), ['A empresa deve possuir somente um sócio principal. Você cadastrou ' + countSocios]);
                return false
            }
            showFormValidationError($('#form-principal'), ['É necessário ter um sócio principal cadastrado.']);
            return false;
        }

        function checkCnaes() {
            var cnaes = $("#form-principal input[name*='cnaes']").serializeArray();
            if (cnaes.length > 0) {
                for (var i in cnaes) {
                    if (cnaes[i].value !== null) return true;
                }
            }
            showFormValidationError($('#form-principal'), ['É necessário adicionar ao menos um CNAE.']);
            return false;

        }

        function validateFormPrincipal() {
            if (checkSocioPrincipal() && checkCnaes()) {
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
    </script>
@stop
@section('top-title')
    <a href="{{route('listEmpresaToUser')}}">Empresas</a> <i class="fa fa-angle-right"></i> Migrar Empresa
@stop
@section('content')
    <form class="form" method="POST" action="" id="form-principal"
          data-validation-url="{{route('validateEmpresa')}}">
    @include('dashboard.components.form-alert')
    @include('dashboard.components.disable-auto-complete')
    {{csrf_field()}}
    <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab"><i class="fa fa-info"></i>
                    Informações da empresa</a>
            </li>
            <li role="presentation">
                <a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab"><i
                            class="fa fa-address-card"></i> Endereço</a>
            </li>
            <li role="presentation">
                <a href="#socios" aria-controls="socios" role="tab" data-toggle="tab"><i class="fa fa-users"></i> Sócios</a>
            </li>
            <li role="presentation">
                <a href="#cnae" aria-controls="cnae" role="tab" data-toggle="tab"><i class="fa fa-list"></i>
                    CNAEs</a>
            </li>
            <li role="presentation">
                <a href="#resumo" aria-controls="resumo" role="tab" data-toggle="tab"><i class="fa fa-calculator"></i>
                    Resumo</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="empresa">
                <div class="form-section">
                    <h4>Informações de Declarante</h4>

                    <p>Complete os dados abaixo com as informações solicitadas.<br/><strong>Campos com * são obrigatórios.</strong></p>
                    <br/>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Fez declaração em {{$ano_anterior}}?</label>
                        <div class="col-md-9">
                            <div class="radio-inline">
                                <label class="control-label">
                                    <input type="radio" name="fez_declaracao" value="1" checked/> Sim
                                </label>
                            </div>
                            <div class="radio-inline ">
                                <label class="control-label">
                                    <input type="radio" name="fez_declaracao" value="0"/> Não
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group declaracao-ano-anterior-group">
                        <label class="col-md-3 label-control">Cópia do recibo da declaração de {{$ano_anterior}}<b>*</b></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button"><span class="fa fa-upload"></span> Enviar Documento
                            </button>
                            <input type="file" name="recibo_declaracao" class="auto-load-file"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>
                    <div class="form-group declaracao-ano-anterior-group">
                        <label class="col-md-3 label-control">Cópia da declaração de {{$ano_anterior}}<b>*</b></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button"><span class="fa fa-upload"></span> Enviar Documento
                            </button>
                            <input type="file" name="declaracao" class="auto-load-file"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>
                    <div class="form-group documentos-declaracao" style="display: none">
                        <label class="col-md-3 label-control">CPF<b>*</b></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button"><span class="fa fa-upload"></span> Enviar Documento
                            </button>
                            <input type="file" name="cpf" class="auto-load-file"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>
                    <div class="form-group documentos-declaracao" style="display: none">
                        <label class="col-md-3 label-control">RG<b>*</b></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button"><span class="fa fa-upload"></span> Enviar Documento
                            </button>
                            <input type="file" name="rg" class="auto-load-file"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>
                    <div class="form-group documentos-declaracao" style="display: none">
                        <label class="col-md-3 label-control">Título de Eleitor<b>*</b></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button"><span class="fa fa-upload"></span> Enviar Documento
                            </button>
                            <input type="file" name="titulo_eleitor" class="auto-load-file"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Comprovante de Residência<b>*</b></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button"><span class="fa fa-upload"></span> Enviar Documento
                            </button>
                            <input type="file" name="comprovante_residencia" class="auto-load-file"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Ocupação<b>*</b></label>
                        <div class="col-md-9">
                            <select name="ocupacao" class="form-control">
                                @foreach(Ocupacao::all() as $ocupacao)
                                    <option title="{{$ocupacao->descricao}}" value="{{$ocupacao->id}}">{{$ocupacao->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Descrição da Ocupação<b>*</b></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="ocupacao_descricao"/>
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <h4>Rendimentos</h4>
                    <p>Deve ser enviado documento comprobatório do declarante, dos valores recebidos
                        em {{$ano_anterior}}</p>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Selecione o tipo de documento</label>
                        <div class="col-md-9">
                            <select class="form-control" name="rendimentos[descricao]">
                                <option value="Rendimentos Recebidos de Pessoa Física ou Exterior">Rendimentos Recebidos de Pessoa
                                    Física ou
                                    Exterior
                                </option>
                                <option value="Rendimentos Recebidos de Pessoa Jurídica">Rendimentos Recebidos de Pessoa Jurídica
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control"></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button" data-tipo="rendimentos"><span class="fa fa-upload"></span>
                                Enviar Documento
                            </button>
                            <input type="file" class="anexar" name="rendimentos[documento]"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>

                    <table class="table  table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Documentos enviados</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="lista_rendimentos">
                        <tr class="nenhum">
                            <td colspan="2">Nenhum rendimento declarado</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-section">
                    <h4>Rendimentos Isentos e Não Tributáveis</h4>
                    <p>Deve ser enviado documento comprobatório do declarante, dos valores recebidos
                        em {{$ano_anterior}}</p>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Selecione o tipo de documento</label>
                        <div class="col-md-9">
                            <select class="form-control" name="rendimentos_isentos[descricao]">
                                <option value="Indenização por rescisão do contrato de trabalho e FGTS">Indenização por rescisão do
                                    contrato
                                    de
                                    trabalho e FGTS
                                </option>
                                <option value="Lucros e Dividendos recebidos">Lucros e Dividendos recebidos</option>
                                <option value="Aposentadoria">Aposentadoria</option>
                                <option value="Rendimentos de Caderneta de Poupança">Rendimentos de Caderneta de Poupança</option>
                                <option value="Doações e Heranças">Doações e Heranças</option>
                                <option value="Bolsa de Estudos">Bolsa de Estudos</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control"></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button" data-tipo="rendimentos_isentos"><span
                                        class="fa fa-upload"></span> Enviar Documento
                            </button>
                            <input type="file" class="anexar" name="rendimentos_isentos[documento]"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>

                    <table class="table  table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Documentos enviados</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="lista_rendimentos_isentos">
                        <tr class="nenhum">
                            <td colspan="2">Nenhum rendimento declarado</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-section">
                    <h4>Rendimentos Sujeitos a Tributação Exclusiva</h4>
                    <p>Deve ser enviado documento comprobatório do declarante, dos valores recebidos em {{$ano_anterior}}</p>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Selecione o tipo de documento</label>
                        <div class="col-md-9">
                            <select class="form-control" name="tributacao_exclusiva[descricao]">
                                <option value="13º Salário">13º Salário
                                </option>
                                <option value="Rendimento de Aplicação Financeira">Rendimento de Aplicação Financeira</option>
                                <option value="Aposentadoria">Lucros e Dividendos recebidos</option>
                                <option value="Juros sobre capital próprio">Juros sobre capital próprio</option>
                                <option value="Participação nos lucros ou Resultados">Participação nos lucros ou Resultados</option>
                                <option value="Venda de bens e direitos">Venda de bens e direitos</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control"></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button" data-tipo="tributacao_exclusiva"><span
                                        class="fa fa-upload"></span> Enviar Documento
                            </button>
                            <input type="file" class="anexar" name="tributacao_exclusiva[documento]"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>


                    <table class="table  table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Documentos enviados</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="lista_tributacao_exclusiva">
                        <tr class="nenhum">
                            <td colspan="2">Nenhum rendimento declarado</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-section">
                    <h4>Recibos - Dedutíveis</h4>
                    <p>Deve ser enviado documento comprobatório do declarante, dos valores recebidos em {{$ano_anterior}}</p>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Selecione o tipo de documento</label>
                        <div class="col-md-9">
                            <select class="form-control" name="recibo_dedutiveis[descricao]">
                                <option value="Instrução">Instrução</option>
                                <option value="Fonoaudiólogos">Fonoaudiólogos</option>
                                <option value="Médicos">Médicos</option>
                                <option value="Dentista">Dentista</option>
                                <option value="Psicólogos">Psicólogos</option>
                                <option value="Fisioterapeutas">Fisioterapeutas</option>
                                <option value="Hospitais, Clínicas e Laboratórios">Hospitais, Clínicas e Laboratórios</option>
                                <option value="Plano de Saúde">Plano de Saúde</option>
                                <option value="Pensão Alimentícia">Pensão Alimentícia</option>
                                <option value="Previdência Complementar">Previdência Complementar</option>
                                <option value="Advogados">Advogados</option>
                                <option value="Engenheiros">Engenheiros</option>
                                <option value="Aluguéis de Imóveis">Aluguéis de Imóveis</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control"></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button" data-tipo="recibo_dedutiveis"><span
                                        class="fa fa-upload"></span> Enviar Documento
                            </button>
                            <input type="file" class="anexar" name="recibo_dedutiveis[documento]"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>

                    <table class="table  table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Documentos enviados</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="lista_recibo_dedutiveis">
                        <tr class="nenhum">
                            <td colspan="2">Nenhum rendimento declarado</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-section">
                    <h4>Doações Efetuadas</h4>
                    <p>Enviar documento comprobatório de doações efetuadas pelo declarante no ano de {{$ano_anterior}}</p>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Valor da Doação</label>
                        <div class="col-md-9">
                            <div class="input-group"><span class="input-group-addon">$</span>
                                <input type="text" value="" name="doacao[descricao]" class="form-control money-mask"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Cópia de CPF e RG para quem foi feita a doação</label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button"  data-tipo="doacao"><span class="fa fa-upload"></span> Enviar Documento</button>
                            <input type="file" class="anexar" name="doacao[documento]"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>
                    <table class="table  table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Doações declaradas</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="lista_doacao">
                        <tr class="nenhum">
                            <td colspan="2">Nenhuma doação declarada</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-section">
                    <h4>Bens e Direitos</h4>
                    <p class="declaracao-ano-anterior-group">Enviar apenas as variações dos bens e direitos adquiridos ou extintos em {{$ano_anterior}}.</p>
                    <p class="documentos-declaracao" style="display:none;">Enviar documento comprobatório dos bens em posse, vendidos e adquiridos em {{$ano_anterior}} pelo declarante.</p>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Selecione o tipo de documento</label>
                        <div class="col-md-9">
                            <select class="form-control" name="bens_direitos[descricao]">
                                <option value="Imóveis">Imóveis</option>
                                <option value="Contas bancárias, corrente, poupança, aplicação, investimento, etc">Contas bancárias, corrente, poupança, aplicação, investimento, etc</option>
                                <option value="Veículos">Veículos</option>
                                <option value="Embarcações">Embarcações</option>
                                <option value="Dinheiro em espécie">Dinheiro em espécie</option>
                                <option value="Participação em empresas">Participação em empresas</option>
                                <option value="Empréstimos a receber">Empréstimos a receber</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control"></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button" data-tipo="bens_direitos"><span class="fa fa-upload"></span>
                                Enviar Documento
                            </button>
                            <input type="file" name="bens_direitos[documento]" class="anexar"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>

                    <table class="table  table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Documentos enviados</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="lista_bens_direitos">
                        <tr class="nenhum">
                            <td colspan="2">Nenhuma declaração de bens e direitos enviada.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-section">
                    <h4>Dívidas e Ônus Reais</h4>
                    <p>Enviar documento comprobatório das dívidas correntes, realizadas e findadas no ano de {{$ano_anterior}} pelo declarante.</p>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Selecione o tipo de documento</label>
                        <div class="col-md-9">
                            <select class="form-control" name="dividas_onus[descricao]">
                                <option value="Empréstimos bancários">Empréstimos bancários</option>
                                <option value="Empréstimos Pessoa Física">Empréstimos Pessoa Física</option>
                                <option value="Empréstimos Pessoa Jurídica">Empréstimos Pessoa Jurídica</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control"></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button" data-tipo="dividas_onus"><span class="fa fa-upload"></span>
                                Enviar Documento
                            </button>
                            <input type="file" name="dividas_onus[documento]" class="anexar"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>

                    <table class="table  table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Documentos enviados</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="lista_dividas_onus">
                        <tr class="nenhum">
                            <td colspan="2">Nenhum documento enviado</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-section">
                    <h4>Doações a Partidos Políticos</h4>
                    <p>Enviar documento comprobatório das doações realizadas pelo declarante em {{$ano_anterior}}</p>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Selecione o tipo de documento</label>
                        <div class="col-md-9">
                            <select class="form-control" name="doacoes_partidos_politicos[descricao]">
                                <option value="Doações a Partidos Políticos - Recibo com CNPJ">Recibo com CNPJ</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control"></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary upload-button" data-tipo="doacoes_partidos_politicos"><span
                                        class="fa fa-upload"></span> Enviar Documento
                            </button>
                            <input type="file" name="doacoes_partidos_politicos[documento]" class="anexar"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>

                    <table class="table  table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Documentos enviados</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="lista_doacoes_partidos_politicos">
                        <tr class="nenhum">
                            <td colspan="2">Nenhum documento enviado</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-section">
                    <h4>Outros</h4>
                    <p>Anexe demais documentos de variação patrimonial que tenha incorrido em {{$ano_anterior}}</p>
                    <div class="form-group">
                        <label class="col-md-3 label-control">Descrição do documento</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="outros[descricao]"
                                   placeholder="Digite uma descrição para o documento"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 label-control"></label>
                        <div class="col-md-9">
                            <button type="button" class="btn btn-primary upload-button" data-tipo="outros"><span class="fa fa-upload"></span> Enviar
                                Documento
                            </button>
                            <input type="file" name="outros[documento]" class="anexar"/>
                            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
                        </div>
                    </div>

                    <table class="table  table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Documentos enviados</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="lista_outros">
                        <tr class="nenhum">
                            <td colspan="2">Nenhum documento enviado</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-section">
                    <h4>Dependentes</h4>

                    <table class="table  table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="lista-dependentes">
                        <tr class="nenhum-dependente-row">
                            <td colspan="2">Nenhum dependente declarado</td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" id="show-dependente-modal"><span class="fa fa-user-plus"></span>
                        Adicionar Dependente
                    </button>
                </div>
                <div class="form-section">
                    <h4>Termo para Envio de Declaração</h4>
                    <div class="form-group">
                        <div class="checkbox-inline">
                            <label class="col-md-12">
                                <input type="checkbox" name="termo" value="1"/> Declaro ter enviado todos os documentos de
                                variação patrimonial em meu nome e de meus dependentes. A
                                ausência de declaração de documentos não anexados é de minha inteira responsabilidade.
                            </label>
                        </div>
                    </div>
                    <button class="btn btn-success" id="send-documentos"><span class="fa fa-send"></span> Enviar Declaração de
                        Imposto de Renda
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="endereco">
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="socios">
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="cnae">
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="resumo">
                <div class="clearfix"></div>
            </div>
        </div>
    </form>

@stop

