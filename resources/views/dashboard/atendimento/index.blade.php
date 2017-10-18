@extends('dashboard.layouts.master')
@section('top-title')
    Atendimento
@stop
@section('content')
    @if($chamados->count())
        <div class="col-xs-12">
            <div class="panel">
                <div class="panel-body">
                    <form class="form-inline">
                        @include('dashboard.components.disable-auto-complete')
                        <input type="hidden" name="tab" value="pendentes">
                        <div class="form-group">
                            <label>Buscar por</label>
                            <input name="busca" class="form-control" value="{{request('busca')}}"/>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="" {{request('status')=='' || !request('status') ? 'selected':''}}>Todos
                                </option>
                                <option value="empresa_desc" {{request('status')=='aberto' ? 'selected':''}}>Aberto
                                </option>
                                <option value="usuario_asc" {{request('status')=='concluido' ? 'selected':''}}>Concluído
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>De</label>
                            <input style="max-width: 90px" name="de" class="form-control date-mask"
                                   value="{{request('de')}}"/>
                        </div>
                        <div class="form-group">
                            <label>Até</label>
                            <input style="max-width: 90px" name="ate" class="form-control date-mask"
                                   value="{{request('ate')}}"/>
                        </div>
                        <div class="form-group">
                            <label>Ordenar por</label>
                            <select name="ordenar" class="form-control">
                                <option value="created_asc" {{request('ordenar')=='created_asc'  ? 'selected':''}}>
                                    Aberto em
                                    (A-Z)
                                </option>
                                <option value="created_desc" {{request('ordenar')=='created_desc' || !request('ordenar')? 'selected':''}}>
                                    Aberto em (Z-A)
                                </option>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <button class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                    </form>
                </div>
            </div>
        </div>
        @foreach($chamados as $chamado)
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><h3 class="panel-title"><i
                                    class="{{$chamado->status == 'Aberto' ? 'fa fa-envelope-open' : 'fa fa-check'}}"></i>
                            Assunto:
                            <strong>{{$chamado->tipoChamado->descricao}}</strong></h3></div>
                    <div class="panel-body">
                        <div><strong>Aberto em</strong> {{$chamado->created_at->format('d/m/Y à\s H:i')}}</div>
                        <div><strong>Status:</strong> {{$chamado->status}}</div>
                        <div>
                            <strong>Descrição:</strong><i>{{'"'.str_limit($chamado->mensagens()->first()->mensagem, 70, '...').'"'}}
                            </i></div>
                        <div><strong>Última
                                mensagem:</strong><i>{{'"'.str_limit($chamado->mensagens()->latest()->first()->mensagem, 70, '...').'"'}}
                            </i>
                            de <strong>{{$chamado->mensagens()->latest()->first()->usuario->nome}}</strong> em
                            <strong>{{$chamado->mensagens()->latest()->first()->created_at->format('d/m/Y à\s H:i')}}</strong>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-primary" href="{{route('viewChamado', [$chamado->id])}}"
                           title="Visualizar"><i class="fa fa-search"></i> Visualizar</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <strong>Você não possui nenhum chamado</strong>, <a href="{{route('newChamado')}}">clique aqui</a>
                    para abrir um novo chamado.
                </div>
            </div>
        </div>
    @endif
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a href="{{route('newChamado')}}" class="btn btn-primary"><i class="fa fa-envelope-open"></i> Quero abrir um
            novo chamado</a>
    </div>
@stop