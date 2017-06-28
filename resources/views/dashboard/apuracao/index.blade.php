@extends('dashboard.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Apurações</h1>
        <p>Aqui você encontra todos as apurações em aberto e também seu histórico de apurações.</p>
        <hr>
    </div>
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Apurações pendentes <span class="badge">{{$apuracoesPendentes->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
                Apurações concluídas</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Imposto</th>
                    <th>Competência</th>
                    <th>Vencimento</th>
                    <th>Novas mensagens</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($apuracoesPendentes->count())
                    @foreach($apuracoesPendentes as $apuracao)
                        <tr>
                            <td>{{$apuracao->empresa->nome_fantasia}}</td>
                            <td>{{$apuracao->imposto->nome}}</td>
                            <td>{{$apuracao->competencia->format('m/Y')}}</td>
                            <td>{{$apuracao->vencimento->format('d/m/Y')}}</td>
                            <td>{{$apuracao->mensagens->where('lida', '=', 0)->count()}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showApuracaoToUser', $apuracao->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>

                    @endforeach
                @else
                    <tr>
                        <td colspan="5">Nenhuma apuração em aberto</td>
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
                    <th>Imposto</th>
                    <th>Competência</th>
                    <th>Vencimento</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($apuracoesConcluidas->count())
                    @foreach($apuracoesConcluidas as $apuracao)
                        <tr>
                            <td>{{$apuracao->empresa->nome_fantasia}}</td>
                            <td>{{$apuracao->imposto->descricao}}</td>
                            <td>{{$apuracao->competencia->format('m/Y')}}</td>
                            <td>{{$apuracao->vencimento->format('d/m/Y')}}</td>
                            <td>{{$apuracao->status}}</td>
                            <td>
                                <a class="btn btn-primary" href="" title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>

                    @endforeach
                @else
                    <tr>
                        <td colspan="5">Nenhuma apuração encontrada</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop