@extends('dashboard.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Atendimento</h1>
        <p>Aqui você encontra todas as suas conversas com nossa equipe.</p>
        <hr>
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12">
        <div class="list-group">
            <a href="{{route('newChamado')}}" class="btn btn-primary"><i class="fa fa-envelope"></i> Clique para abrir
                um chamado </a>
        </div>
    </div>
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
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="chamados">
            <div class="col-sm-12">
                <h3>Chamados</h3>
            </div>
            @if($chamados->count())
                @foreach($chamados as $chamado)

                    <div class="col-lg-4 col-sm-6">
                        <div class="panel">
                            <div class="items">
                                <div class="col-xs-12">
                                    <i class="fa item-icon fa-info text-success"></i>
                                    <div class="item-value">{{$chamado->tipoChamado->descricao}}</div>
                                    <div class="item-description">Aberto
                                        em: {{$chamado->created_at->format('H:i - d/m/Y')}}</div>
                                </div>
                                <div class="col-xs-12">
                                    <i class="fa item-icon fa-envelope text-success"></i>
                                    <div class="item-value">{{$chamado->mensagens()->latest()->first()->mensagem}}</div>
                                    <div class="item-description">Recebido
                                        em: {{$chamado->mensagens()->latest()->first()->created_at->format('H:i - d/m/Y')}}</div>
                                </div>
                                <div class="col-xs-12">
                                    <i class="fa item-icon fa-question-circle text-success"></i>
                                    <div class="item-value">{{$chamado->status}}</div>
                                    <div class="item-description">Status</div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <hr>
                            <div class="col-xs-12">
                                <a href="{{route('viewChamado', $chamado->id)}}" class="btn btn-primary"><i class="fa fa-search"></i> Visualizar</a>
                            </div>
                            <div class="clearfix"></div>
                            <br/>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-sm-12">Nenhum chamado encontrado</div>
            @endif
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="empresas">
            @foreach($empresas as $empresa)
                {{$empresa->id}}
            @endforeach
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="abertura-empresas">
            @foreach($aberturaEmpresas as $aberturaEmpresa)
                {{$aberturaEmpresa->id}}
            @endforeach
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="solicitacoes">
            @foreach($solicitacoes as $solicitacao)
                {{$solicitacao->id}}
            @endforeach
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
