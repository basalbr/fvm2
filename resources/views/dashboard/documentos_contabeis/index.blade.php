@extends('dashboard.layouts.master')
@section('top-title')
    Documentos Contábeis
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Documentos contábeis pendentes <span class="badge">{{$processosPendentes->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
                Documentos contábeis concluídos</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <p>{{Auth::user()->nome}}, aqui é onde você vai enviar todos os documentos das suas empresas cadastradas em nosso sistema para contabilizarmos.<br /> Para enviar seus documentos, basta clicar em visualizar na listagem abaixo.<br />Se não houve movimentação ou não possui documentos para enviar, pedimos para que informe que não houve movimentação clicando no botão "sem movimento" que vai aparecer após clicar em visualizar.</p>
            <p><strong>Atenção:</strong> As notas de entrada e saída devem ser enviadas nas <a href="{{route('listApuracoesToUser')}}">apurações</a>, não aqui.</p>
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Período</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($processosPendentes->count())
                    @foreach($processosPendentes as $documento)
                        <tr>
                            <td><a href="{{route('showEmpresaToUser', $documento->empresa->id)}}">{{$documento->empresa->nome_fantasia}} ({{$documento->empresa->razao_social}})</a></td>
                            <td>{{$documento->periodo->format('m/Y')}}</td>
                            <td>{{$documento->getStatus()}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showDocumentoContabilToUser', $documento->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Nenhum período pendente</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Período</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($processosConcluidos->count())
                    @foreach($processosConcluidos as $documento)
                        <tr>
                            <td>{{$documento->empresa->nome_fantasia}}</td>
                            <td>{{$documento->periodo->format('m/Y')}}</td>
                            <td>{{$documento->getStatus()}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showDocumentoContabilToUser', $documento->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Nenhum processo encontrado</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop