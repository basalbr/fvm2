@extends('layouts.master')

@if(isset($login))
@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#modal-access').modal('show');
        })
    </script>
@stop
@endif

@section('js')
    @parent
    @if($atendimento)
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/59b975184854b82732fefd9f/default';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
        @endif
    <script type="text/javascript" src="{{url(public_path().'js/modules/simulate.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('#contrato').on('click', function(){
                $('#modal-contrato').modal('show');
            })
        })
    </script>
@stop


@section('content')

    <section id="main-banner" class="section">
        <input type="hidden" value="{{route('getMonthlyPaymentParams')}}" id="payment-parameters">

        @include('index.components.banner-principal')
    </section>
    <section id="imposto-renda" class="section">
        @include('index.components.imposto-renda')
    </section>
    <section id="como-funciona" class="section">
        @include('index.components.como-funciona')
    </section>

    <section id="mensalidade" class="section">
        @include('index.components.mensalidade')
    </section>
    <section id="noticias" class="section">
        @include('index.components.noticias')
    </section>
    <section id="duvidas" class="section">
        @include('index.components.duvidas')
    </section>

    <div class="clearfix"></div>
@stop
