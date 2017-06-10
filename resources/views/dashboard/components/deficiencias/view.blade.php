@foreach($dependentes as $dependente)
    <div class="modal animated fadeInUpBig" id="modal-dependente-{{$dependente->id}}" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{$dependente->nome}}</h3>
                </div>

                <div class="modal-body">
                    <div class="col-xs-12">
                        <h4>Informações</h4>
                        <p>Abaixo estão as informações de {{$dependente->nome}}.</p>
                        <hr>
                    </div>
                    @include('dashboard.components.form-alert')
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="">


                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="nome">Nome completo</label>
                            <div class='form-control'>{{$dependente->nome}}</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="nome_mae">Nome da mãe</label>
                            <div class='form-control'>{{$dependente->nome_mae}}</div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="nome_pai">Nome do pai</label>
                            <div class='form-control'>{{$dependente->nome_pai}}</div>

                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="data_nascimento">Data de nascimento</label>
                            <div class='form-control'>{{$dependente->data_nascimento->format('d/m/Y')}}</div>

                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="estado_civil">Estado civil</label>
                            <div class='form-control'>{{ucfirst($dependente->estado_civil)}}</div>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class='form-group'>
                            <label for="regime_casamento">Regime de casamento</label>
                            <div class='form-control'>{{$dependente->regimeCasamento ? $dependente->regimeCasamento->descricao : 'Nenhum'}}</div>

                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="nacionalidade">Nacionalidade</label>
                            <div class='form-control'>{{$dependente->nacionalidade}}</div>

                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class='form-group'>
                            <label for="email">E-mail</label>
                            <div class='form-control'>{{$dependente->email}}</div>

                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="telefone">Telefone</label>
                            <div class='form-control'>{{$dependente->telefone}}</div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="cpf">CPF</label>
                            <div class='form-control'>{{$dependente->cpf}}</div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="rg">RG</label>
                            <div class='form-control'>{{$dependente->rg}}</div>

                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class='form-group'>
                            <label for="orgao_expedidor">Órgão Expedidor do RG (Ex: SSP/SC)</label>
                            <div class='form-control'>{{$dependente->orgao_expedidor}}</div>

                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="principal">Título de eleitor</label>
                            <div class='form-control'>{{$dependente->titulo_eleitor}}</div>

                        </div>

                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="principal">É o sócio principal?</label>
                            <div class='form-control'>{{$dependente->principal == 1 ? 'Sim' : 'Não'}}</div>

                        </div>

                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="pro_labore">Valor de Pró-labore</label>
                            <div class='form-control'>{{$dependente->getProLaboreFormatado()}}</div>

                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="pis">PIS</label>
                            <div class='form-control'>{{$dependente->pis}}</div>

                        </div>
                    </div>
                    <div class="col-xs-12">
                        <h4>Endereço</h4>
                        <hr>
                    </div>
                    <div class="col-xs-2">
                        <div class='form-group'>
                            <label for="cep">CEP</label>
                            <div class='form-control'>{{$dependente->cep}}</div>

                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="id_uf">Estado</label>
                            <div class='form-control'>{{$dependente->uf->nome}}</div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="cidade">Cidade</label>
                            <div class='form-control'>{{$dependente->cidade}}</div>

                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="bairro">Bairro</label>
                            <div class='form-control'>{{$dependente->bairro}}</div>

                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class='form-group'>
                            <label for="endereco">Endereço</label>
                            <div class='form-control'>{{$dependente->endereco}}</div>

                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class='form-group'>
                            <label for="numero">Número</label>
                            <div class='form-control'>{{$dependente->numero}}</div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="complemento">Complemento</label>
                            <div class='form-control'>{{$dependente->complemento}}</div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach