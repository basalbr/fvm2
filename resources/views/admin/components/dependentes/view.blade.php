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
                    <div class="col-sm-6">
                        <div class='form-group'>
                            <label for="nome">Nome completo *</label>
                            <div class="form-control">{{$dependente->nome}}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            <label for="id_tipo_dependencia">Tipo de dependência *</label>
                            <div class="form-control">{{$dependente->tipo->descricao}}</div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class='form-group'>
                            <label for="cpf">CPF</label>
                            <div class="form-control">{{$dependente->cpf}}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class='form-group'>
                            <label for="rg">RG</label>
                            <div class="form-control">{{$dependente->rg}}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            <label for="orgao_expedidor_rg">Órgão Expedidor do RG</label>
                            <div class="form-control">{{$dependente->orgao_expedidor_rg}}</div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class='form-group'>
                            <label for="data_nascimento">Data de Nascimento *</label>
                            <div class="form-control">{{$dependente->data_nascimento->format('d/m/Y')}}</div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class='form-group'>
                            <label for="local_nascimento">Local de nascimento *</label>
                            <div class="form-control">{{$dependente->local_nascimento}}</div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class='form-group'>
                            <label for="matricula">Matrícula da certidão de nascimento</label>
                            <div class="form-control">{{$dependente->matricula}}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            <label for="cartorio">Nome do cartório</label>
                            <div class="form-control">{{$dependente->cartorio}}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            <label for="numero_cartorio">Número de registro do cartório</label>
                            <div class="form-control">{{$dependente->numero_cartorio}}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            <label for="numero_livro">Número do livro</label>
                            <div class="form-control">{{$dependente->numero_livro}}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            <label for="numero_folha">Número da folha</label>
                            <div class="form-control">{{$dependente->numero_folha}}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            <label for="numero_dnv">Número da D.N.V</label>
                            <div class="form-control">{{$dependente->numero_dnv}}</div>
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