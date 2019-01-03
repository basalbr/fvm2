@extends('dashboard.layouts.master')
@section('top-title')
    Abertura de empresa
@stop
@section('content')
    @if(count($aberturaEmpresas))
        @foreach($aberturaEmpresas as $aberturaEmpresa)
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>{{$aberturaEmpresa->nome_empresarial1}}</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div><strong>Razão social:</strong> {{$aberturaEmpresa->nome_empresarial1}}</div>
                        <div><strong>Nome fantasia:</strong> {{$aberturaEmpresa->nome_empresarial2}}</div>
                        <div><strong>Sócio principal:</strong> {{$aberturaEmpresa->getSocioPrincipal()->nome}}</div>
                        <div><strong>Etapa do processo:</strong> {{$aberturaEmpresa->getNomeEtapa()}}</div>
                        <div><strong>Status: </strong>{{$aberturaEmpresa->getDescricaoEtapa()}}</div>
                        <div><strong>Solicitado em:</strong> {{$aberturaEmpresa->created_at->format('d/m/Y')}}</div>
                    </div>
                    <div class="panel-footer">
                        @if($aberturaEmpresa->ordemPagamento->isPending())
                            <a target="_blank" href="{{$aberturaEmpresa->ordemPagamento->getBotaoPagamento()}}"
                               class="btn btn-success"><i class="fa fa-credit-card"></i>
                                Pagar {{$aberturaEmpresa->ordemPagamento->formattedValue()}}</a>
                        @endif
                        <a class="btn btn-primary {{$aberturaEmpresa->getQtdMensagensNaoLidas() > 0 ? 'animated shake' : ''}}"
                           href="{{route('showAberturaEmpresaToUser', [$aberturaEmpresa->id])}}"
                           title="Visualizar"><i class="fa fa-search"></i>
                            Ver detalhes {!! $aberturaEmpresa->getQtdMensagensNaoLidas() > 0 ? ' <span class="label label-primary">Existem '.$aberturaEmpresa->getQtdMensagensNaoLidas().' mensagens não lidas</span>' : ''!!}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <strong>Você não solicitou nenhuma abertura de empresa</strong>, <a
                            href="{{route('newAberturaEmpresa')}}">clique aqui</a>
                    para solicitar a abertura de sua empresa conosco.
                </div>
            </div>
        </div>
    @endif
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <button data-toggle="modal" data-target="#modal-abertura-empresa" class="btn btn-primary"><span
                    class="fa fa-child"></span> Solicitar
            abertura de empresa
        </button>
    </div>
@stop
@section('modals')
    <div class="modal animated fadeIn" id="modal-abertura-empresa" tabindex="-1" role="dialog" style="z-index: 99999">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Termo de compromisso</h3>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        <p>O serviço de abertura de empresa consiste em:</p>
                        <ul>
                            <li>Solicitação de viabilidade junto à JUCESC;</li>
                            <li>Obtenção de CNPJ junto à Receita Federal;</li>
                            <li>Solicitação de inscrição municipal e estadual (quando for comércio ou indústria);</li>
                            <li>Solicitação do primeiro alvará junto aos bombeiros e prefeitura;</li>
                            <li>Enquadramento no Simples Nacional.</li>
                        </ul>
                        <p>A entrega física de documentos, seja para regularização de alguma solicitação por parte dos
                            referidos órgãos e/ou protocolo físico, <strong>será feito pelo contratante</strong>.</p>
                        <p><strong>Neste serviço não está incluso o valor da mensalidade</strong>, que será cobrada
                            desde a data de abertura do CNPJ para envio das declarações após o término desse processo de
                            abertura de empresa.</p>
                        <p>Se o contratante perca algum prazo para protocolar algum documento (normalmente 30 dias),
                            será necessário refazer o processo.</p>
                        <p><strong>Ao prosseguir significa que você compreende e aceita esse termo de
                                compromisso.</strong></p>
                        <p>Caso tenha alguma dúvida, basta <a href="{{route('newChamado')}}">abrir um chamado</a> que
                            ficaremos felizes em ajudar.</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <a href="{{route('newAberturaEmpresa')}}" class="btn btn-primary"><span class="fa fa-child"></span>
                        Solicitar
                        abertura de empresa</a>
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

@stop
