@extends('admin.layouts.master')
@section('top-title')
    Alterações Contratuais
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Pendentes <span class="badge">{{$pendentes->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#concluidas" aria-controls="concluidas" role="tab" data-toggle="tab"><i
                        class="fa fa-check"></i>
                Concluídas</a>
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
                    <th>Usuário</th>
                    <th>Tipo de alteração</th>
                    <th>Data de alteração</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @if($pendentes->count())
                    @foreach($pendentes as $alteracao)
                        <tr>
                            <td><a href="{{route('showFuncionarioToAdmin',  [$alteracao->funcionario->empresa->id, $alteracao->funcionario->id])}}">{{$alteracao->funcionario->nome_completo}}</a></td>
                            <td><a href="{{route('showEmpresaToAdmin', $alteracao->funcionario->empresa->id)}}">{{$alteracao->funcionario->empresa->nome_fantasia}}</a></td>
                            <td><a href="{{route('showUsuarioToAdmin', $alteracao->funcionario->empresa->usuario->id)}}">{{$alteracao->funcionario->empresa->usuario->nome}}</a></td>
                            <td>{{$alteracao->tipo->descricao}}</td>
                            <td>{{$alteracao->data_alteracao->format('d/m/Y')}}</td>

                            <td>
                                <a class="btn btn-primary" href="{{route('showAlteracaoContratualToAdmin', [$alteracao->id])}}" title="Visualizar">
                                    <i class="fa fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">Nenhuma solicitação de alteração encontrada</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="concluidas">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Funcionário</th>
                    <th>Empresa</th>
                    <th>Usuário</th>
                    <th>Tipo de alteração</th>
                    <th>Data de alteração</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @if($concluidas->count())
                    @foreach($concluidas as $alteracao)
                        <tr>
                            <td><a href="{{route('showFuncionarioToAdmin',  [$alteracao->funcionario->empresa->id, $alteracao->funcionario->id])}}">{{$alteracao->funcionario->nome_completo}}</a></td>
                            <td><a href="{{route('showEmpresaToAdmin', $alteracao->funcionario->empresa->id)}}">{{$alteracao->funcionario->empresa->nome_fantasia}}</a></td>
                            <td><a href="{{route('showUsuarioToAdmin', $alteracao->funcionario->empresa->usuario->id)}}">{{$alteracao->funcionario->empresa->usuario->nome}}</a></td>
                            <td>{{$alteracao->tipo->descricao}}</td>
                            <td>{{$alteracao->data_alteracao->format('d/m/Y')}}</td>

                            <td>
                                <a class="btn btn-primary" href="{{route('showAlteracaoContratualToAdmin', [$alteracao->id])}}" title="Visualizar">
                                    <i class="fa fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">Nenhuma solicitação de alteração encontrada</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="col-xs-12 navigation-options">
            <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
        </div>
    </div>
    <div class="clearfix"></div>

@stop