@extends('dashboard.layouts.master')
@section('top-title')
    Recálculos
@stop
@section('content')

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="pendentes">
            @if($recalculos->count() >0)
                <div class="panel-body">
                    <p class="alert alert-info" style="display: block">Caso tenha perdido o prazo de algum imposto é possível solicitar o recálculo do mesmo! Abaixo estão as suas solicitações de recálculo.</p>
                    <table class="table table-hovered table-striped">
                        <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Solicitado em</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <div class="clearfix"></div>
                            @foreach($recalculos as $recalculo)
                                <tr>
                                    <td>{{$recalculo->tipo->descricao}}</td>
                                    <td>{{$recalculo->getStatus()}}</td>
                                    <td>{{$recalculo->created_at->format('d/m/Y')}}
                                        @if($recalculo->qtdeMensagensNaoLidas())

                                        @endif
                                    </td>
                                    <td>
                                        @if($recalculo->pagamento->isPending())
                                            <a class="btn btn-success"
                                               href="{{$recalculo->pagamento->getBotaoPagamento()}}"
                                               title="Efetuar pagamento"><i class="fa fa-credit-card"></i>
                                                Pagar {{$recalculo->pagamento->formattedValue()}}</a>
                                        @endif
                                        <a class="btn btn-primary"
                                           href="{{route('showRecalculoToUser',$recalculo->id)}}"
                                           title="Visualizar"><i class="fa fa-search"></i> Visualizar</a>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                    {{ $recalculos->appends(request()->query())->links() }}
                    <div class="clearfix"></div>
                </div>
            @else
                <div class="col-xs-12"><h4><strong>Você ainda não solicitou nenhum recálculo!</strong></h4></div>
                <div class="panel-body">
                    <p>Caso tenha perdido o prazo de algum imposto é possível solicitar o recálculo do mesmo.</p>
                    <p>Basta clicar no botão abaixo e informar o imposto, a competência de recálculo e a data em que
                        pretende efetuar o pagamento.</p>
                    <a href="{{route('newRecalculo')}}" class="btn btn-primary"><span class="fa fa-repeat"></span>
                        Solicitar recálculo</a>
                </div>
            @endif
            <div class="clearfix"></div>
        </div>

    </div>
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a href="{{route('newRecalculo')}}" class="btn btn-primary"><span class="fa fa-repeat"></span>
            Solicitar recálculo</a>
    </div>
@stop
