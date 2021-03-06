@extends('admin.layouts.master')
@section('top-title')
    Abertura de empresa
@stop
@section('content')
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#aprovadas" aria-controls="chamados" role="tab" data-toggle="tab"><i class="fa fa-warning"></i>
                Pendentes</a>
        </li>
        <li role="presentation">
            <a href="#pendentes" aria-controls="empresas" role="tab" data-toggle="tab"><i class="fa fa-check"></i>
                Concluídas</a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="aprovadas">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Nome Preferencial</th>
                    <th>Etapa</th>
                    <th>Aberto em</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($empresasPendentes->count())
                    @foreach($empresasPendentes as $empresa)
                        <tr>
                            <td><a href="{{route('showUsuarioToAdmin',$empresa->id_usuario)}}">{{$empresa->usuario->nome}}</a></td>
                            <td>{{$empresa->nome_empresarial1}}</td>
                            <td>{{$empresa->getNomeEtapa()}}</td>
                            <td>{{$empresa->created_at->format('d/m/Y')}}</td>
                            <td>
                                <a href="{{route('showAberturaEmpresaToAdmin', $empresa->id)}}" class="btn btn-primary"><i
                                            class="fa fa-search"></i> Ver Detalhes</a>
                            </td>
                        </tr>

                    @endforeach
                @else
                    <tr>
                        <td colspan="7">Nenhuma empresa encontrada</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="pendentes">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Razão Social</th>
                    <th>Status</th>
                    <th>Aberto em</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($empresasConcluidas->count())
                    @foreach($empresasConcluidas as $empresa)
                        <tr>
                            <td><a href="{{route('showUsuarioToAdmin',$empresa->id_usuario)}}">{{$empresa->usuario->nome}}</a></td>
                            <td>{{$empresa->nome_empresarial1}}</td>
                            <td>{{$empresa->getNomeEtapa()}}</td>
                            <td>{{$empresa->created_at->format('d/m/Y')}}</td>
                            <td>
                                <a href="{{route('showAberturaEmpresaToAdmin', $empresa->id)}}" class="btn btn-primary"><i
                                            class="fa fa-search"></i> Ver Detalhes</a>
                            </td>
                        </tr>

                    @endforeach
                @else
                    <tr>
                        <td colspan="7">Nenhuma empresa encontrada</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>


@stop

