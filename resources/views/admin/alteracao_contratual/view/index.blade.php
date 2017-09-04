@extends('admin.layouts.master')
@section('top-title')
    <a href="{{route('listAlteracaoContratualToAdmin')}}">Alterações Contratuais</a> <i class="fa fa-angle-right"></i> <a href="{{route('showEmpresaToAdmin', $alteracao->funcionario->empresa->id)}}">{{$alteracao->funcionario->empresa->nome_fantasia}}</a> <i class="fa fa-angle-right"></i> <a href="{{route('showFuncionarioToAdmin', [$alteracao->funcionario->empresa->id, $alteracao->funcionario->id])}}">{{$alteracao->funcionario->nome_completo}}</a>
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#docs" aria-controls="docs" role="tab" data-toggle="tab"><i class="fa fa-info"></i>
                Principal</a>
        </li>
        <li role="presentation">
            <a href="#mensagens" aria-controls="mensagens" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Mensagens <span
                        class="badge">{{$alteracao->mensagens()->where('lida','=',0)->where('from_admin','=',1)->count()}}</span></a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane animated fadeIn active" id="docs">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Funcionário</label>
                    <div class="form-control">
                        <a href="{{route('showFuncionarioToUser', [$alteracao->funcionario->empresa->id, $alteracao->funcionario->id])}}">
                            {{$alteracao->funcionario->nome_completo}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Empresa</label>
                    <div class="form-control">
                        <a href="{{route('showEmpresaToUser', [$alteracao->funcionario->empresa->id])}}">
                            {{$alteracao->funcionario->empresa->nome_fantasia}} ({{$alteracao->funcionario->empresa->razao_social}})
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Usuário</label>
                    <div class="form-control">
                        <a href="{{route('showUsuarioToAdmin', [$alteracao->funcionario->empresa->usuario->id])}}">
                            {{$alteracao->funcionario->empresa->nome_fantasia}} ({{$alteracao->funcionario->empresa->razao_social}})
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Tipo de alteração</label>
                    <select class="form-control" name="id_tipo_alteracao_contratual">
                        @foreach($tiposAlteracoes as $tipoAlteracao)
                            <option {{$tipoAlteracao->id == $alteracao->tipo->id ? 'selected' : ''}} value="{{$tipoAlteracao->id}}">{{$tipoAlteracao->descricao}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Data de alteração</label>
                    <input class="form-control date-mask" name="data_alteracao" value="{{$alteracao->data_alteracao->format('d/m/Y')}}"/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Motivo</label>
                    <textarea name="motivo" class="form-control">{{$alteracao->motivo}}</textarea>
                </div>
            </div>
            @if($alteracao->tipo->id == 1)
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Valor do novo salário</label>
                        <input class="form-control money-mask" name="salario" value="{{$alteracao->getSalario()}}"/>
                    </div>
                </div>
            @endif
            @if($alteracao->tipo->id == 2)
                <div class="jornada-option">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="id_grau_instrucao">D.S.R</label>
                            <select class="form-control" id='dsr' name='dsr'>
                                @foreach($dow as $n => $dia)
                                    <option value="{{$n}}" {{$n == $alteracao->dsr ? 'selected="selected"' : ''}}>{{$dia}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @include('admin.components.horario.view', ['contrato'=>$alteracao, 'horarios'=>$alteracao->horarios])
                </div>
            @endif
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="mensagens">
            @if($alteracao->status == 'concluido')
                @include('admin.components.chat.box', ['model'=>$alteracao, 'lockMessages'=>'true'])
            @else
                @include('admin.components.chat.box', ['model'=>$alteracao])
            @endif
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="navigation-options animated slideInUp">
            <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
        </div>
    </div>

@stop
