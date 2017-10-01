@extends('admin.layouts.master')
@section('top-title')
    Tarefas
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Pendentes <span class="badge">{{$tarefasPendentes->count()}}</span></a>
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
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Referência</th>
                    <th>Responsável</th>
                    <th>Última atualização</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @if($tarefasPendentes->count())
                    @foreach($tarefasPendentes as $tarefa)
                        <tr>
                            <td>{{ $tarefa->descricao }}</td>
                            <td>{{ $tarefa->getStatus() }}</td>
                            <td>{{ $tarefa->responsavel->nome }}</td>
                            <td>{{ $tarefa->updated_at->format('d/m/Y - H:i') }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showTarefaToAdmin', $tarefa->id)}}"
                                   title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">Nenhuma tarefa encontrada</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Referência</th>
                    <th>Responsável</th>
                    <th>Última atualização</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @if($tarefasConcluidas->count())
                    @foreach($tarefasConcluidas as $tarefa)
                        <tr>
                            <td>{{ $tarefa->descricao }}</td>
                            <td>{{ $tarefa->responsavel->nome }}</td>
                            <td>{{ $tarefa->updated_at->format('d/m/Y - H:i') }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showTarefaToAdmin', $tarefa->id)}}"
                                   title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">Nenhuma tarefa encontrada</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop