@extends('dashboard.layouts.master')
@section('top-title')
    <a href="{{route('listDemissaoToUser')}}">Demissões</a> <i class="fa fa-angle-right"></i> <a
            href="{{route('showEmpresaToUser', $demissao->funcionario->empresa->id)}}">{{$demissao->funcionario->empresa->nome_fantasia}}</a>
    <i class="fa fa-angle-right"></i> <a
            href="{{route('showFuncionarioToUser', [$demissao->funcionario->empresa->id, $demissao->funcionario->id])}}">{{$demissao->funcionario->nome_completo}}</a>
@stop
@section('content')

    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#principal" aria-controls="principal" role="tab" data-toggle="tab"><i class="fa fa-info"></i>
                Principal</a>
        </li>
        <li role="presentation">
            <a href="#mensagens" aria-controls="mensagens" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Mensagens <span
                        class="badge">{{$demissao->mensagens()->where('lida','=',0)->where('from_admin','=',1)->count()}}</span></a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane animated fadeIn active" id="principal">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Funcionário</label>
                    <div class="form-control">
                        <a href="{{route('showFuncionarioToUser', [$demissao->funcionario->empresa->id, $demissao->funcionario->id])}}">
                            {{$demissao->funcionario->nome_completo}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Empresa</label>
                    <div class="form-control">
                        <a href="{{route('showEmpresaToUser', [$demissao->funcionario->empresa->id])}}">
                            {{$demissao->funcionario->empresa->nome_fantasia}}
                            ({{$demissao->funcionario->empresa->razao_social}})
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Status da solicitação</label>
                    <div class="form-control">{{$demissao->getStatus()}}</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Tipo de demissão *</label>
                    <select class="form-control" name="id_tipo_demissao" disabled>
                        <option value="1" {{$demissao->id_tipo_demissao == 1 ? 'selected' : ''}}>Empresa está
                            demitindo
                        </option>
                        <option value="2" {{$demissao->id_tipo_demissao == 2 ? 'selected' : ''}}>Funcionário
                            solicitou demissão
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Tipo de aviso prévio *</label>
                    <select class="form-control" name="id_tipo_aviso_previo" disabled>
                        <option value="1" {{$demissao->id_tipo_aviso_previo == 1 ? 'selected' : ''}}>Trabalhado
                        </option>
                        <option value="2" {{$demissao->id_tipo_aviso_previo == 1 ? 'selected' : ''}}>Indenizado
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Data de demissão *</label>
                    <input class="form-control" name="data_demissao"
                           value="{{$demissao->data_demissao->format('d/m/Y')}}" disabled/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Observações</label>
                    <textarea class="form-control" disabled>{{$demissao->observacoes}}</textarea>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12"><h3>Documentos</h3></div>
                @include('dashboard.components.uploader.default', ['lock'=>true, 'idReferencia'=>$demissao->id, 'referencia'=>$demissao->getTable(), 'anexos'=>$demissao->anexos])
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="mensagens">
            @if($demissao->status == 'concluido')
                @include('dashboard.components.chat.box', ['model'=>$demissao, 'lockMessages'=>'true'])
            @else
                @include('dashboard.components.chat.box', ['model'=>$demissao])
            @endif
        </div>
        <div class="clearfix"></div>
        <div class="navigation-space"></div>
        <div class="animated slideInUp navigation-options">
            <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
        </div>
    </div>

@stop
