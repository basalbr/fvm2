@extends('dashboard.layouts.master')
@section('top-title')
    Apurações
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Pendentes <span class="badge">{{$apuracoesPendentes->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-check"></i>
                Concluídas</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <p class="alert alert-info" style="display: block"><strong>Abaixo estão as apurações pendentes</strong> de envio de notas fiscais emitidas e recebidas.<br />Para enviar as notas fiscais clique no botão de visualizar (ícone de lupa).</p>
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Tributação</th>
                    <th>Competência</th>
                    <th>Vencimento</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($apuracoesPendentes->count())
                    @foreach($apuracoesPendentes as $apuracao)
                        <tr>
                            <td>{{$apuracao->empresa->razao_social}}</td>
                            <td>{{$apuracao->imposto->nome}}</td>
                            <td>{{$apuracao->competencia->format('m/Y')}}</td>
                            <td>{{$apuracao->vencimento->format('d/m/Y')}}</td>
                            <td>{!! $apuracao->getLabelStatus()  !!}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showApuracaoToUser', $apuracao->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">Nenhuma apuração em aberto</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
            <p>{{Auth::user()->nome}}, abaixo estão as apurações sem movimento e/ou concluídas (com as guias geradas para pagamento).<br />Para acessar a guia ou ver outras informações, clique em visualizar.</p>
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Tributação</th>
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
                            <td>{{$apuracao->imposto->nome}}</td>
                            <td>{{$apuracao->competencia->format('m/Y')}}</td>
                            <td>{{$apuracao->vencimento->format('d/m/Y')}}</td>
                            <td>{{$apuracao->status}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showApuracaoToUser', $apuracao->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i>
                                </a>
                            </td>
                        </tr>

                    @endforeach
                @else
                    <tr>
                        <td colspan="6">Nenhuma apuração encontrada</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop