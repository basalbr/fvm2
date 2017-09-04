@extends('admin.layouts.master')
@section('top-title')
    Apuração de Folha
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Pendentes <span class="badge">{{$empresasPendentes->count()}}</span></a>
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
                    <th>CNPJ</th>
                    <th>Empresa</th>
                    <th>Razão Social</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($empresasPendentes->count())
                    @foreach($empresasPendentes as $empresa)
                        <tr>
                            <td>{{$empresa->cnpj}}</td>
                            <td>{{$empresa->nome_fantasia}}</td>
                            <td>{{$empresa->razao_social}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('createProcessoFolha', $empresa->id)}}"
                                   title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Nenhum processamento pendente</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>CNPJ</th>
                    <th>Empresa</th>
                    <th>Razão Social</th>
                    <th>Competência</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($historicoFolha->count())
                    @foreach($historicoFolha as $folha)
                        <tr>
                            <td>{{$folha->empresa->cnpj}}</td>
                            <td>{{$folha->empresa->nome_fantasia}}</td>
                            <td>{{$folha->empresa->razao_social}}</td>
                            <td>{{$folha->competencia->format('m/Y')}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showProcessoFolhaToAdmin', $folha->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">Nenhum processo encontrado</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop