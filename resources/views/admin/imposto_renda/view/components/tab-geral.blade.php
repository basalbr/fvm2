<div role="tabpanel" class="tab-pane active animated fadeIn" id="tab-geral">
    <p class="alert-info alert" style="display: block"><strong>Informações pessoais</strong></p>
    <div class="col-xs-12">
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <td><strong>Usuário</strong></td>
                <td><a href="{{route('showUsuarioToAdmin', $ir->id_usuario)}}">{{$ir->usuario->nome}}</a></td>
            </tr>
            <tr>
                <td><strong>Nome do Declarante</strong></td>
                <td>{{$ir->declarante->nome}}</td>
            </tr>
            <tr>
                <td><strong>Status da declaração</strong></td>
                <td>{{$ir->getStatus()}}</td>
            </tr>
            <tr>
                <td><strong>Status do pagamento</strong></td>
                <td>{{$ir->getPaymentStatus()}}</td>
            </tr>
            @if($ir->declarante->data_nascimento)
                <tr>
                    <td><strong>Data de nascimento</strong></td>
                    <td>{{$ir->declarante->data_nascimento->format('d/m/Y')}}</td>
                </tr>
            @endif
            <tr>
                <td><strong>Ocupação</strong></td>
                <td>{{$ir->declarante->tipo_ocupacao->descricao}}</td>
            </tr>
            <tr>
                <td><strong>Descrição da ocupação</strong></td>
                <td>{{$ir->declarante->ocupacao ? $ir->declarante->ocupacao : '-'}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
    <p class="alert-info alert" style="display: block"><strong>Documentos do declarante</strong></p>
    <div class="col-xs-12">
        <table class="table table-striped table-hover">
            <tbody>
            @if($ir->recibo_anterior)
                <tr>
                    <td><strong>Recibo do ano anterior</strong></td>
                    <td><a target="_blank"
                           href="{{asset(public_path().'storage/anexos/imposto_renda/'. $ir->id . '/' . $ir->recibo_anterior)}}">Download</a>
                    </td>
                </tr>
            @endif
            @if($ir->declaracao_anterior)
                <tr>
                    <td><strong>Declaração do ano anterior</strong></td>
                    <td><a target="_blank"
                           href="{{asset(public_path().'storage/anexos/imposto_renda/'. $ir->id . '/' . $ir->declaracao_anterior)}}">Download</a>
                    </td>
                </tr>
            @endif
            @if($ir->declarante->comprovante_residencia)
                <tr>
                    <td><strong>Comprovante de residência</strong></td>
                    <td><a target="_blank"
                           href="{{asset(public_path().'storage/anexos/ir_declarante/'. $ir->declarante->id . '/' . $ir->declarante->comprovante_residencia)}}">Download</a>
                    </td>
                </tr>
            @endif
            @if($ir->declarante->rg)
                <tr>
                    <td><strong>RG</strong></td>
                    <td><a target="_blank"
                           href="{{asset(public_path().'storage/anexos/ir_declarante/'. $ir->declarante->id . '/' . $ir->declarante->rg)}}">Download</a>
                    </td>
                </tr>
            @endif
            @if($ir->declarante->cpf)
                <tr>
                    <td><strong>CPF</strong></td>
                    <td><a target="_blank"
                           href="{{asset(public_path().'storage/anexos/ir_declarante/'. $ir->declarante->id . '/' . $ir->declarante->cpf)}}">Download</a>
                    </td>
                </tr>
            @endif
            @if($ir->declarante->titulo_eleitor)
                <tr>
                    <td><strong>CPF</strong></td>
                    <td><a target="_blank"
                           href="{{asset(public_path().'storage/anexos/ir_declarante/'. $ir->declarante->id . '/' . $ir->declarante->titulo_eleitor)}}">Download</a>
                    </td>
                </tr>
            @endif
            @foreach($ir->anexos as $anexo)
                <tr>
                    <td><strong>{{$anexo->descricao}}</strong></td>
                    <td>
                        <a target="_blank"
                           href="{{asset(public_path().'storage/anexos/'.$anexo->referencia.'/'. $anexo->id_referencia . '/' . $anexo->arquivo)}}">Download</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
    @foreach($ir->dependentes as $dependente)
        <p class="alert-info alert" style="display: block"><strong>Dependente: {{$dependente->nome}}</strong></p>
        <div class="col-xs-12">
            <table class="table table-striped table-hover">
                <tbody>
                <tr>
                    <td><strong>Nome do dependente</strong></td>
                    <td>{{$dependente->nome}}</td>
                </tr>
                <tr>
                    <td><strong>Tipo</strong></td>
                    <td>{{$dependente->tipo->descricao}}</td>
                </tr>
                <tr>
                    <td><strong>Data de nascimento</strong></td>
                    <td>{{$dependente->data_nascimento->format('d/m/Y')}}</td>
                </tr>
                @if($dependente->rg)
                    <tr>
                        <td><strong>RG</strong></td>
                        <td><a target="_blank"
                               href="{{asset(public_path().'storage/anexos/ir_dependente/'. $dependente->id . '/' . $dependente->rg)}}">Download</a>
                        </td>
                    </tr>
                @endif
                @if($dependente->cpf)
                    <tr>
                        <td><strong>CPF</strong></td>
                        <td><a target="_blank"
                               href="{{asset(public_path().'storage/anexos/ir_dependente/'. $dependente->id . '/' . $dependente->cpf)}}">Download</a>
                        </td>
                    </tr>
                @endif
                @foreach($dependente->anexos as $anexo)
                    <tr>
                        <td><strong>{{$anexo->descricao}}</strong></td>
                        <td>
                            <a target="_blank"
                               href="{{asset(public_path().'storage/anexos/'.$anexo->referencia.'/'. $anexo->id_referencia . '/' . $anexo->arquivo)}}">Download</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
    @endforeach

    <div class="clearfix"></div>
</div>