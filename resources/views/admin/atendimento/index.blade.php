@extends('admin.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Atendimento</h1>
        <hr>
    </div>
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#chamados" aria-controls="chamados" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Chamados</a>
        </li>
        <li role="presentation">
            <a href="#empresas" aria-controls="empresas" role="tab" data-toggle="tab"><i class="fa fa-building"></i>
                Empresas</a>
        </li>
        <li role="presentation">
            <a href="#abertura-empresas" aria-controls="abertura-empresas" role="tab" data-toggle="tab"><i
                        class="fa fa-child"></i>
                Abertura de Empresa</a>
        </li>
        <li role="presentation">
            <a href="#solicitacoes" aria-controls="solicitacoes" role="tab" data-toggle="tab"><i
                        class="fa fa-bullhorn"></i>
                Solicitações</a>
        </li>
        <li role="presentation">
            <a href="#apuracoes" aria-controls="apuracoes" role="tab" data-toggle="tab"><i
                        class="fa fa-calendar-check-o"></i>
                Apurações</a>
        </li>
        <li role="presentation">
            <a href="#documentos-contabeis" aria-controls="documentos-contabeis" role="tab" data-toggle="tab"><i
                        class="fa fa-files-o"></i>
                Documentos contábeis</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="chamados">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Assunto</th>
                    <th>Status</th>
                    <th>Aberto em</th>
                    <th>Última mensagem</th>
                    <th>Recebida em</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($chamados->count())
                    @foreach($chamados as $chamado)
                        <tr>
                            <td>{{$chamado->usuario->nome}}</td>
                            <td>{{$chamado->tipoChamado->descricao}}</td>
                            <td>{{$chamado->status}}</td>
                            <td>{{$chamado->created_at->format('d/m/Y H:i')}}</td>
                            <td>{{$chamado->mensagens()->latest()->first()->mensagem}}</td>
                            <td>{{$chamado->mensagens()->latest()->first()->created_at->format('d/m/Y H:i')}}</td>
                            <td><a class="btn btn-primary" href="{{route('showChamadoToAdmin', [$chamado->id])}}"
                                   title="Visualizar"><i class="fa fa-search"></i></a></td>
                        </tr>

                    @endforeach
                @else
                    <tr>
                        <td colspan="7">Nenhum chamado encontrado</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="empresas">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Última mensagem</th>
                    <th>Novas mensagens?</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($empresas as $empresa)
                    <tr>
                        <td>{{$empresa->nome_fantasia}}</td>
                        <td>{{$empresa->mensagens()->latest()->first()->mensagem}}</td>
                        <td>{{$empresa->getQtdeMensagensNaoLidas()}}</td>
                        <td><a class="btn btn-primary" href="{{route('showEmpresaToAdmin', [$empresa->id])}}"
                               title="Visualizar"><i class="fa fa-search"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="abertura-empresas">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Última mensagem</th>
                    <th>Novas mensagens?</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($aberturaEmpresas as $aberturaEmpresa)
                    <tr>
                        <td>{{$aberturaEmpresa->nome_empresarial1}}</td>
                        <td>{{$aberturaEmpresa->mensagens()->latest()->first()->mensagem}}</td>
                        <td>{{$aberturaEmpresa->getQtdeMensagensNaoLidas()}}</td>
                        <td><a class="btn btn-primary"
                               href="{{route('showAberturaEmpresaToAdmin', [$aberturaEmpresa->id])}}"
                               title="Visualizar"><i class="fa fa-search"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="solicitacoes">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Solicitação</th>
                    <th>Última mensagem</th>
                    <th>Novas mensagens?</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($solicitacoes as $solicitacao)
                    <tr>
                        <td>{{$solicitacao->usuario->nome}}</td>
                        <td>{{$solicitacao->tipo->descricao}}</td>
                        <td>{{$solicitacao->getUltimaMensagem()}}</td>
                        <td>{{$solicitacao->getQtdeMensagensNaoLidas()}}</td>
                        <td><a class="btn btn-primary"
                               href="{{route('showSolicitacaoAlteracaoToAdmin', [$solicitacao->id])}}"
                               title="Visualizar"><i class="fa fa-search"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="apuracoes">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Apuração</th>
                    <th>Competência</th>
                    <th>Última mensagem</th>
                    <th>Novas mensagens?</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($apuracoes as $apuracao)
                    <tr>
                        <td>{{$apuracao->empresa->nome_fantasia}}</td>
                        <td>{{$apuracao->imposto->nome}}</td>
                        <td>{{$apuracao->competencia->format('m/Y')}}</td>
                        <td>{{$apuracao->getUltimaMensagem()}}</td>
                        <td>{{$apuracao->getQtdeMensagensNaoLidas()}}</td>
                        <td><a class="btn btn-primary"
                               href="{{route('showSolicitacaoAlteracaoToAdmin', [$solicitacao->id])}}"
                               title="Visualizar"><i class="fa fa-search"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="documentos-contabeis">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Período</th>
                    <th>Última mensagem</th>
                    <th>Novas mensagens?</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($documentosContabeis as $processo)
                    <tr>
                        <td>{{$processo->empresa->nome_fantasia}}</td>
                        <td>{{$processo->periodo->format('m/Y')}}</td>
                        <td>{{$processo->getUltimaMensagem()}}</td>
                        <td>{{$processo->getQtdeMensagensNaoLidas()}}</td>
                        <td><a class="btn btn-primary"
                               href="{{route('showSolicitacaoAlteracaoToAdmin', [$solicitacao->id])}}"
                               title="Visualizar"><i class="fa fa-search"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop
@section('modals')
    @parent
    <div class="modal animated fadeInDown" id="modal-escolha-empresa" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Cadastrar funcionário</h3>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        <p>Para cadastrar um funcionário é necessário selecionar uma empresa primeiro.<br/>
                            Escolha uma empresa na lista abaixo e clique em avançar.</p>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            @if($empresas->count())
                                @foreach($empresas as $empresa)
                                    <a href="{{route('newFuncionario',[$empresa->id])}}">{{$empresa->nome_fantasia}}</a>
                                @endforeach
                            @else
                                <p>Você não cadastrou nenhuma empresa ainda.<br/>Caso queira abrir uma empresa, <a
                                            href="{{route('newAberturaEmpresa')}}">clique aqui.</a><br/>Para migrar uma
                                    empresa, <a href="{{route('newEmpresa')}}">clique aqui</a></p>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>
@stop
