@extends('admin.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Apuração de Folha</h1>
        <hr>
    </div>
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
                Histórico</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane animated fadeIn active" id="historico">
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
                                <a class="btn btn-primary" href="{{route('showProcessoFolhaToUser', $folha->id)}}" title="Visualizar">
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