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
                            <h4>Informações</h4>
                            <p>Complete as informações abaixo e clique em adicionar. Campos com * são obrigatórios.</p>
                            <hr>
                        </div>
                        @include('dashboard.components.form-alert')
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="">


                        <div class="col-xs-4">
                            <div class='form-group'>
                                <label for="nome">Nome completo *</label>
                                <input type='text' class='form-control' name='nome'/>
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class='form-group'>
                                <label for="nome_mae">Nome da mãe *</label>
                                <input type='text' class='form-control' name='nome_mae'/>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class='form-group'>
                                <label for="nome_pai">Nome do pai *</label>
                                <input type='text' class='form-control' name='nome_pai'/>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class='form-group'>
                                <label for="data_nascimento">Data de Nascimento *</label>
                                <input type='text' class='form-control date-mask' name='data_nascimento'/>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class='form-group'>
                                <label for="estado_civil">Estado civil *</label>
                                <select name="estado_civil" class="form-control">
                                    <option value="solteiro">Solteiro</option>
                                    <option value="casado">Casado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class='form-group'>
                                <label for="id_regime_casamento">Regime de casamento</label>
                                <select name="id_regime_casamento" class="form-control">
                                    <option value="">Não está casado</option>
                                    @foreach($regimesCasamento as $regimeCasamento)
                                        <option value="{{$regimeCasamento->id}}">{{$regimeCasamento->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class='form-group'>
                                <label for="nacionalidade">Nacionalidade *</label>
                                <input type='text' class='form-control' name='nacionalidade'/>
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class='form-group'>
                                <label for="email">E-mail *</label>
                                <input type='text' class='form-control' name='email'/>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class='form-group'>
                                <label for="telefone">Telefone *</label>
                                <input type='text' class='form-control phone-mask' name='telefone'/>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class='form-group'>
                                <label for="cpf">CPF *</label>
                                <input type='text' class='form-control cpf-mask' name='cpf'/>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class='form-group'>
                                <label for="rg">RG *</label>
                                <input type='text' class='form-control' name='rg'/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class='form-group'>
                                <label for="orgao_expedidor">Órgão Expedidor do RG (Ex: SSP/SC) *</label>
                                <input type='text' class='form-control' name='orgao_expedidor'/>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class='form-group'>
                                <label for="pro_labore">Título de Eleitor *</label>
                                <input type='text' class='form-control' name='titulo_eleitor'/>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class='form-group'>
                                <label for="principal">É o sócio principal? *</label>
                                <select name="principal" class="form-control">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class='form-group'>
                                <label for="pro_labore">Valor de Pró-labore</label>
                                <input type='text' class='form-control money-mask' name='pro_labore'/>

                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class='form-group'>
                                <label for="pis">PIS</label>
                                <input type='text' class='form-control pis-mask' name='pis'/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <h4>Endereço</h4>
                            <hr>
                        </div>
                        <div class="col-xs-2">
                            <div class='form-group'>
                                <label for="cep">CEP *</label>
                                <input type='text' class='form-control cep-mask' name='cep'/>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class='form-group'>
                                <label for="id_uf">Estado *</label>
                                <select name="id_uf" class="form-control">
                                    <option value="">Escolha uma opção</option>
                                    @foreach($ufs as $uf)
                                        <option value="{{$uf->id}}">{{$uf->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class='form-group'>
                                <label for="cidade">Cidade *</label>
                                <input type='text' class='form-control' name='cidade'/>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class='form-group'>
                                <label for="bairro">Bairro *</label>
                                <input type='text' class='form-control' name='bairro'/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class='form-group'>
                                <label for="endereco">Endereço *</label>
                                <input type='text' class='form-control' name='endereco'/>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class='form-group'>
                                <label for="numero">Número *</label>
                                <input type='text' class='form-control' name='numero'/>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class='form-group'>
                                <label for="complemento">Complemento</label>
                                <input type='text' class='form-control' name='complemento'/>
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