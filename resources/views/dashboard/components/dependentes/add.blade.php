@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'js/dashboard/modules/dependentes.js')}}"></script>
@stop
@section('modals')
    @parent
    <!--Remover dependente modal -->
    <div class="modal animated fadeInUpBig" id="modal-remove-dependente" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Remover Dependente</h3>
                </div>

                <div class="modal-body">
                    Tem certeza que deseja remover <span id="dependente-name"></span> da lista de dependentes?
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
    <!-- Adicionar Dependente Modal -->
    <div class="modal animated fadeInUpBig" id="modal-dependente" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Adicionar Dependente</h3>
                </div>

                <div class="modal-body">
                    <form class="form" data-validation-url="{{$validationUrl}}" action="">

                        <div class="col-sm-12">
                            <h4>Informações</h4>
                            <p>Complete as informações abaixo e clique em adicionar. Campos com * são obrigatórios.</p>
                            <hr>
                        </div>
                        @include('dashboard.components.form-alert')
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="">


                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="nome">Nome completo *</label>
                                <input type='text' class='form-control' name='nome'/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="id_tipo_dependencia">Tipo de dependência *</label>
                                <select name="id_tipo_dependencia" class="form-control">
                                    <option value="">Escolha uma opção</option>
                                    @foreach($tiposDependencia as $tipoDependencia)
                                        <option value="{{$tipoDependencia->id}}">{{$tipoDependencia->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class='form-group'>
                                <label for="cpf">CPF</label>
                                <input type='text' class='form-control cpf-mask' name='cpf'/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class='form-group'>
                                <label for="rg">RG</label>
                                <input type='text' class='form-control' name='rg'/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="orgao_expedidor_rg">Órgão Expedidor do RG</label>
                                <input type='text' class='form-control' name='orgao_expedidor_rg'/>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class='form-group'>
                                <label for="data_nascimento">Data de Nascimento *</label>
                                <input type='text' class='form-control date-mask' name='data_nascimento'/>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class='form-group'>
                                <label for="local_nascimento">Local de nascimento *</label>
                                <input type='text' class='form-control' name='local_nascimento'/>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class='form-group'>
                                <label for="matricula">Matrícula da certidão de nascimento</label>
                                <input type='text' class='form-control' name='matricula'/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="cartorio">Nome do cartório</label>
                                <input type='text' class='form-control' name='cartorio'/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="numero_cartorio">Número de registro do cartório</label>
                                <input type='text' class='form-control' name='numero_cartorio'/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="numero_livro">Número do livro</label>
                                <input type='text' class='form-control' name='numero_livro'/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="numero_folha">Número da folha</label>
                                <input type='text' class='form-control' name='numero_folha'/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group'>
                                <label for="numero_dnv">Número da D.N.V</label>
                                <input type='text' class='form-control' name='numero_dnv'/>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                    <button class="btn btn-success" type="button"><i class="fa fa-plus"></i> Adicionar Dependente
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop