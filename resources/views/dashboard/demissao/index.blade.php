@extends('dashboard.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Demissões</h1>
        <p>Aqui você poderá ver os pedidos de demissão em processamento e os pedidos de demissão já concluídos.</p>
        <hr>
    </div>
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Pendentes <span class="badge">{{$demissoesPendentes->count()}}</span></a>
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
                    <th>Funcionário</th>
                    <th>Empresa</th>
                    <th>Data de demissão</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @if($demissoesPendentes->count())
                    @foreach($demissoesPendentes as $demissao)
                        <tr>
                            <td><a href="{{route('showFuncionarioToUser', [$demissao->funcionario->empresa->id, $demissao->funcionario->id])}}">
                                    {{$demissao->funcionario->nome_completo}}
                                </a></td>
                            <td><a href="{{route('showEmpresaToUser', [$demissao->funcionario->empresa->id])}}">
                                    {{$demissao->funcionario->empresa->nome_fantasia}} ({{$demissao->funcionario->empresa->razao_social}})
                                </a></td>
                            <td>{{$demissao->data_demissao->format('d/m/Y')}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showDemissaoToUser', $demissao->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Nenhuma solicitação de demissão pendente</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Funcionário</th>
                    <th>Empresa</th>
                    <th>Data de demissão</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @if($demissoesConcluidas->count())
                    @foreach($demissoesConcluidas as $demissao)
                        <tr>
                            <td><a href="{{route('showFuncionarioToUser', [$demissao->funcionario->empresa->id, $demissao->funcionario->id])}}">
                                    {{$demissao->funcionario->nome_completo}}
                                </a></td>
                            <td><a href="{{route('showEmpresaToUser', [$demissao->funcionario->empresa->id])}}">
                                    {{$demissao->funcionario->empresa->nome_fantasia}} ({{$demissao->funcionario->empresa->razao_social}})
                                </a></td>
                            <td>{{$demissao->data_demissao->format('d/m/Y')}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showDemissaoToUser', $demissao->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Nenhuma solicitação de demissão concluída</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop