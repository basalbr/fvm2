@extends('admin.layouts.master')
@section('top-title')
    Documentos Contábeis
@stop

@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-exclamation-circle"></i>
                Documentos contábeis pendentes <span class="badge">{{$processosPendentes->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
                Documentos contábeis concluídos</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Período</th>
                    <th>Status</th>
                    <th>Novas mensagens</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($processosPendentes->count())
                    @foreach($processosPendentes as $documento)
                        <tr>
                            <td>{{$documento->empresa->nome_fantasia}}</td>
                            <td>{{$documento->periodo->format('m/Y')}}</td>
                            <td>{{$documento->mensagens->where('lida', '=', 0)->where('admin', '=', 1)->count()}}</td>
                            <td>{{$documento->getStatus()}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showDocumentoContabilToAdmin', $documento->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Nenhum processo encontrado</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{ $processosPendentes->appends(request()->query())->links() }}
            <div class="clearfix"></div>
        </div>
        <div role="tabpanel" class="tab-pane animated fadeIn" id="historico">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Período</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($processosConcluidos->count())
                    @foreach($processosConcluidos as $documento)
                        <tr>
                            <td>{{$documento->empresa->nome_fantasia}}</td>
                            <td>{{$documento->periodo->format('m/Y')}}</td>
                            <td>{{$documento->getStatus()}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showDocumentoContabilToAdmin', $documento->id)}}" title="Visualizar">
                                    <i class="fa fa-search"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Nenhum processo encontrado</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{ $processosConcluidos->appends(request()->query())->links() }}
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop