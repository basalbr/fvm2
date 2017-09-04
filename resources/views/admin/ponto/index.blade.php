@extends('admin.layouts.master')
@section('top-title')
    Registros de Ponto
@stop
@section('content')
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Pendentes <span class="badge">{{$pontosPendentes->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
                Concluídos</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Período</th>
                    <th>Vencimento</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @if($pontosPendentes->count())
                    @foreach($pontosPendentes as $ponto)
                        <tr>
                            <td>{{$ponto->empresa->nome_fantasia}}</td>
                            <td>{{$ponto->periodo->format('m/Y')}}</td>
                            <td>04/{{$ponto->created_at->format('m/Y')}}</td>
                            <td>{{$ponto->getStatus()}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showPontoToAdmin', $ponto->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">Nenhuma solicitação de envio de registro de ponto</td>
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

                @if($pontosConcluidos->count())
                    @foreach($pontosConcluidos as $ponto)
                        <tr>
                            <td>{{$ponto->empresa->nome_fantasia}}</td>
                            <td>{{$ponto->periodo->format('m/Y')}}</td>
                            <td>{{$ponto->getStatus()}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showPontoToAdmin', $ponto->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Nenhum encontrado</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop