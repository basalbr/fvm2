@foreach($socios as $socio)
    <div class="modal animated fadeInUpBig" id="modal-socio-{{$socio->id}}" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{$socio->nome}}</h3>
                </div>

                <div class="modal-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Nome</th>
                            <td>{{$socio->nome}}</td>
                        </tr>
                        <tr>
                            <th>Nome da mãe</th>
                            <td>{{$socio->nome_mae}}</td>
                        </tr>
                        <tr>
                            <th>Nome do pai</th>
                            <td>{{$socio->nome_pai}}</td>
                        </tr>
                        <tr>
                            <th>Data de nascimento</th>
                            <td>{{$socio->data_nascimento->format('d/m/Y')}}</td>
                        </tr>
                        <tr>
                            <th>Estado civil</th>
                            <td>{{ucfirst($socio->estado_civil)}}</td>
                        </tr>
                        <tr>
                            <th>Regime de casamento</th>
                            <td>{{$socio->regimeCasamento ? $socio->regimeCasamento->descricao : 'Nenhum'}}</td>
                        </tr>
                        <tr>
                            <th>Naturalidade</th>
                            <td>{{$socio->municipio}}</td>
                        </tr>
                        <tr>
                            <th>Nacionalidade</th>
                            <td>{{$socio->nacionalidade}}</td>
                        </tr>
                        <tr>
                            <th>E-mail</th>
                            <td>{{$socio->email}}</td>
                        </tr>
                        <tr>
                            <th>Telefone</th>
                            <td>{{$socio->telefone}}</td>
                        </tr>
                        <tr>
                            <th>CPF</th>
                            <td>{{$socio->cpf}}</td>
                        </tr>
                        <tr>
                            <th>RG</th>
                            <td>{{$socio->rg}}</td>
                        </tr>
                        <tr>
                            <th>Órgão expedidor</th>
                            <td>{{$socio->orgao_expedidor}}</td>
                        </tr>
                        <tr>
                            <th>Título de eleitor</th>
                            <td>{{$socio->titulo_eleitor}}</td>
                        </tr>
                        <tr>
                            <th>Pró-labore</th>
                            <td>{{$socio->getProLaboreFormatado()}}</td>
                        </tr>
                        <tr>
                            <th>PIS</th>
                            <td>{{$socio->pis}}</td>
                        </tr>
                        <tr>
                            <th>Endereço</th>
                            <td>{{$socio->getEnderecoCompleto()}}</td>
                        </tr>
                    </table>
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