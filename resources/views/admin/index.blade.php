@extends('admin.layouts.master')
@section('content')
    <h1>Seja bem vindo {{Auth::user()->nome}}</h1>
    <div class="clearfix"></div>
@stop