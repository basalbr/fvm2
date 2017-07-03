@extends('dashboard.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Empresas</h1>
        <p>Nesta área você pode solicitar uma migração de empresa de sua contabilidade atual para a WEBContabilidade e
            visualizar suas empresas cadastradas no sistema.</p>
        <hr>
    </div>
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#aprovadas" aria-controls="chamados" role="tab" data-toggle="tab"><i class="fa fa-check"></i>
                Empresas ativas</a>
        </li>
        <li role="presentation">
            <a href="#pendentes" aria-controls="empresas" role="tab" data-toggle="tab"><i class="fa fa-hourglass-1"></i>
                Empresas em análise</a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="aprovadas">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Nome Fantasia</th>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($empresasAtivas->count())
                    @foreach($empresasAtivas as $empresa)
                        <tr>
                            <td>{{$empresa->usuario->nome}}</td>
                            <td>{{$empresa->nome_fantasia}}</td>
                            <td>{{$empresa->razao_social}}</td>
                            <td>{{$empresa->cnpj}}</td>
                            <td>
                                <a href="{{route('showEmpresaToAdmin', $empresa->id)}}" class="btn btn-primary"><i
                                            class="fa fa-search"></i> Ver Detalhes</a>
                                @if($empresa->status != 'Aprovado')
                                    <a href="{{route('activateEmpresa', $empresa->id)}}" class="btn btn-success">
                                        <i class="fa fa-check"></i> Ativar
                                    </a>
                                @endif
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
                    <th>Nome Fantasia</th>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($empresasPendentes->count())
                    @foreach($empresasPendentes as $empresa)
                        <tr>
                            <td>{{$empresa->usuario->nome}}</td>
                            <td>{{$empresa->nome_fantasia}}</td>
                            <td>{{$empresa->razao_social}}</td>
                            <td>{{$empresa->cnpj}}</td>
                            <td>
                                <a href="{{route('showEmpresaToAdmin', $empresa->id)}}" class="btn btn-primary"><i
                                            class="fa fa-search"></i> Ver Detalhes</a>
                                @if($empresa->status != 'Aprovado')
                                    <a href="{{route('activateEmpresa', $empresa->id)}}" class="btn btn-success">
                                        <i class="fa fa-check"></i> Ativar
                                    </a>
                                @endif
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

