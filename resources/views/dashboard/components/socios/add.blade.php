@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'js/dashboard/modules/socios.js')}}"></script>
@stop
@section('modals')
    @parent
    <!--Remover sócio modal -->
    <div class="modal animated fadeInUpBig" id="modal-remove-socio" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Remover Sócio</h3>
                </div>

                <div class="modal-body">
                    Tem certeza que deseja remover <span id="socio-name"></span> da lista de sócios?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-id=""><i class="fa fa-trash"></i> Sim, desejo
                        remover
                    </button>
                    <button class="btn btn-default" data-dismiss="modal">Não, cliquei errado</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Adicionar Sócio Modal -->
    <div class="modal animated fadeInUpBig" id="modal-socio" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Adicionar Sócio</h3>
                </div>

                <div class="modal-body">
                    <form class="form" data-validation-url="{{$validationUrl}}" action="">
                        <div class="col-xs-12">
                            <div class="alert alert-info" style="display:block">
                                <p>Complete as informações abaixo e clique em Adicionar Sócio. <strong>Campos com * são obrigatórios.</strong></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        @include('dashboard.components.form-alert')
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="">
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="nome">Nome completo *</label>
                                <input type='text' class='form-control' name='nome' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o nome completo"/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="cpf">CPF *</label>
                                <input type='text' class='form-control cpf-mask' name='cpf' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o CPF"/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="nome_mae">Nome da mãe *</label>
                                <input type='text' class='form-control' name='nome_mae' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o nome completo da mãe"/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="nome_pai">Nome do pai *</label>
                                <input type='text' class='form-control' name='nome_pai' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o nome completo do pai"/>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="data_nascimento">Data de Nascimento *</label>
                                <input type='text' class='form-control date-mask' name='data_nascimento' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe a data de nascimento"/>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="municipio">Naturalidade *</label>
                                <input type='text' class='form-control' name='municipio' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o município e estado onde nasceu"/>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="nacionalidade">Nacionalidade *</label>
                                <input type='text' class='form-control' name='nacionalidade' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe a nacionalidade"/>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="principal">É o sócio principal? *</label>
                                <select name="principal" class="form-control" data-toggle="tooltip"
                                        data-placement="top"
                                        title="Informe se esse será o sócio principal, responsável pela empresa perante à Receita Federal">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="estado_civil">Estado civil *</label>
                                <select name="estado_civil" class="form-control" data-toggle="tooltip"
                                        data-placement="top"
                                        title="Informe corretamente o estado civil">
                                    <option value="solteiro">Solteiro</option>
                                    <option value="casado">Casado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="id_regime_casamento">Regime de casamento</label>
                                <select name="id_regime_casamento" class="form-control" data-toggle="tooltip"
                                        data-placement="top"
                                        title="Informe corretamente o Regime de Casamento, caso seja casado(a)">
                                    <option value="">Não está casado</option>
                                    @foreach($regimesCasamento as $regimeCasamento)
                                        <option value="{{$regimeCasamento->id}}">{{$regimeCasamento->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="email">E-mail *</label>
                                <input type='text' class='form-control' name='email' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o e-mail do sócio"/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="telefone">Telefone *</label>
                                <input type='text' class='form-control phone-mask' name='telefone' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o telefone do sócio"/>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="rg">RG *</label>
                                <input type='text' class='form-control' name='rg' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o RG"/>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class='form-group'>
                                <label for="orgao_expedidor">Órgão Expedidor do RG *</label>
                                <input type='text' class='form-control' name='orgao_expedidor' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o Órgão Expedidor do RG, por exemplo, SSP/SC"/>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="pro_labore">Título de Eleitor *</label>
                                <input type='text' class='form-control' name='titulo_eleitor' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o título de eleitor"/>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="pro_labore">Valor de Pró-labore</label>
                                <input type='text' class='form-control money-mask' name='pro_labore' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o valor que irá retirar de pró-labore"/>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="pis">PIS</label>
                                <input type='text' class='form-control pis-mask' name='pis' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Caso retire pró-labore é necessário informar o PIS"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                            <hr>
                        <div class="col-sm-3">
                            <div class='form-group'>
                                <label for="cep">CEP *</label>
                                <input type='text' class='form-control cep-mask' name='cep' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o CEP do endereço"/>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class='form-group'>
                                <label for="id_uf">Estado *</label>
                                <select name="id_uf" class="form-control" data-toggle="tooltip"
                                        data-placement="top"
                                        title="Selecione a UF do endereço">
                                    <option value="">Escolha uma opção</option>
                                    @foreach($ufs as $uf)
                                        <option data-sigla="{{$uf->sigla}}" value="{{$uf->id}}">{{$uf->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class='form-group'>
                                <label for="cidade">Cidade *</label>
                                <input type='text' class='form-control' name='cidade' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe a cidade"/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="bairro">Bairro *</label>
                                <input type='text' class='form-control' name='bairro' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o bairro"/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="endereco">Endereço *</label>
                                <input type='text' class='form-control' name='endereco' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o endereço"/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="numero">Número *</label>
                                <input type='text' class='form-control' name='numero' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o número do endereço"/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="complemento">Complemento</label>
                                <input type='text' class='form-control' name='complemento' data-toggle="tooltip"
                                       data-placement="top"
                                       title="Informe o complemento do endereço"/>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                    <button class="btn btn-success" type="button"><i class="fa fa-plus"></i> Adicionar Sócio</button>
                </div>
            </div>
        </div>
    </div>
@stop