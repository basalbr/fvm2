@extends('admin.layouts.master')
@section('top-title')
    Balancete
@stop
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                        class="fa fa-list"></i>
                Histórico</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            <table class="table table-hovered table-striped">
                <thead>
                <tr>
                    <th>Exercício</th>
                    <th>CNPJ</th>
                    <th>Razão Social</th>
                    <th>Usuário</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <div class="clearfix"></div>
                @if($balancetes->count())
                    @foreach($balancetes as $balancete)
                        <tr>
                            <td>{{$balancete->exercicio->format('m/Y')}}</td>
                            <td>{{$balancete->empresa->cnpj}}</td>
                            <td><a href="{{route('showEmpresaToAdmin', $balancete->empresa->id)}}">{{$balancete->empresa->razao_social}}</a></td>
                            <td><a href="{{route('showUsuarioToAdmin', $balancete->empresa->id_usuario)}}">{{$balancete->empresa->usuario->nome}}</a></td>
                            <td>
                                <a class="btn btn-primary" href="{{route('showBalanceteToAdmin', $balancete->id)}}"
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
    </div>
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a href="{{route('newBalancete')}}" class="btn btn-primary"><i class="fa fa-send"></i> Enviar um balancete</a>
    </div>
@stop