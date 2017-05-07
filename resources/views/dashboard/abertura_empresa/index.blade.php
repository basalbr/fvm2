@extends('dashboard.layouts.master')
@section('content')
    <h1>Abertura de empresa</h1>
    <hr>
    @foreach($aberturaEmpresas as $aberturaEmpresa)
        <div class="col-sm-4">
            <div class="panel">
                <h3>{{$aberturaEmpresa->nome_empresarial1}}</h3>
                <p>{{$aberturaEmpresa->getSocioPrincipal()->nome}}</p>
                <p>{{$aberturaEmpresa->getSocioPrincipal()->nome}}</p>
                <p>{{$aberturaEmpresa->status}}</p>
                <p>{{$aberturaEmpresa->getPaymentStatus()}}</p>
                <p>{{$aberturaEmpresa->getMonthlyPayment()}}</p>
            </div>

        </div>
    @endforeach
@stop

