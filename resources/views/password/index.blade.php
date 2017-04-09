@extends('layouts.master')
@section('content')
    <section id="password" class="section">
        <div class="container">
            <h1>Digite sua nova senha no formulário abaixo e clique no botão "alterar senha" para alterar sua
                senha.</h1>
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <form class="form" method="POST" action="{{route('doResetPassword')}}">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    {{csrf_field()}}
                    <input type="hidden" value="{{$token}}" name="token">
                    <input type="hidden" value="{{$email}}" name="email">
                    <div class="form-group">
                        <label>Digite sua nova senha</label>
                        <input name="password" class="form-control" value="" type="password"/>
                    </div>
                    <div class="form-group">
                        <label>Confirme sua nova senha</label>
                        <input name="password_confirmation" class="form-control" value="" type="password"/>
                    </div>
                    <button class="btn btn-complete">Alterar senha</button>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </section>
    <div class="clearfix"></div>
@stop
