@extends('dashboard.layouts.master')
@section('content')
    <h1>Seja bem vindo {{Auth::user()->nome}}</h1>
    <div class="col-md-4">
        <a href="{{route('newAberturaEmpresa')}}" class="shortcut blue">
            <div class="big-icon"><span class="fa fa-child"></span></div>
            <h3 class="text-center">Abrir Empresa</h3>
        </a>
    </div>
    <div class="col-md-4">
        <a href="http://www.webcontabilidade.com/empresas/cadastrar" class="shortcut green">
            <div class="big-icon"><span class="fa fa-exchange"></span></div>
            <h3 class="text-center">Migrar Empresa</h3>
        </a>
    </div>
    <div class="col-md-4">
        <a href="http://www.webcontabilidade.com/apuracoes" class="shortcut mint">
            <div class="big-icon"><span class="fa fa-file"></span></div>
            <div class="contador">0</div>
            <h3 class="text-center">Apurações em aberto</h3>
        </a>
    </div>
    <div class="col-md-4">
        <a href="http://www.webcontabilidade.com/admin/chamados" class="shortcut blue">
            <div class="big-icon"><span class="fa fa-envelope"></span></div>
            <div class="contador">1</div>
            <h3 class="text-center">Chamados</h3>
        </a>
    </div>
    <div class="col-md-4">
        <a href="http://www.webcontabilidade.com/pagamentos-pendentes" class="shortcut orange">
            <div class="big-icon"><span class="fa fa-credit-card"></span></div>
            <div class="contador">0</div>
            <h3 class="text-center">Pagamentos Pendentes</h3>
        </a>
    </div>
    <div class="col-md-4">
        <a href="http://www.webcontabilidade.com/usuario" class="shortcut green">
            <div class="big-icon"><span class="fa fa-user"></span></div>
            <h3 class="text-center">Meus dados</h3>
        </a>
    </div>
    <div class="clearfix"></div>
@stop