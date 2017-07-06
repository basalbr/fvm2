@extends('dashboard.layouts.master')
@section('content')
    <div class="col-xs-12">
        <h1>Pró-labores</h1>
        <hr>
    </div>
    <div class="clearfix"></div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Pró-labores pendentes <span class="badge">{{$sociosPendentes->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
                Pró-labores concluídos</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Sócio</th>
                    <th>Valor</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($sociosPendentes->count())
                    @foreach($sociosPendentes as $socio)
                        <tr>
                            <td>{{$socio->empresa->nome_fantasia}}</td>
                            <td>{{$socio->nome}}</td>
                            <td>{{$socio->getProLaboreFormatado()}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('createProLabore', $socio->id)}}"
                                   title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Nenhum pró-labore pendente</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Sócio</th>
                    <th>Competência</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($historicoProlabore->count())
                    @foreach($historicoProlabore as $proLabore)
                        <tr>
                            <td>{{$proLabore->socio->empresa->nome_fantasia}}</td>
                            <td>{{$proLabore->socio->nome}}</td>
                            <td>{{$proLabore->competencia->format('m/Y')}}</td>
                            <td>{{$proLabore->getProLaboreFormatado()}}</td>
                            <td>
                                <a class="btn btn-primary" href="" title="Visualizar">
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