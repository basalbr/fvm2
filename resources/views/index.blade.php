@extends('layouts.master')

@if(isset($login))
    @section('js')
        @parent
        <script type="text/javascript">
            $(function(){
                $('#modal-access').modal('show');

            })
        </script>
        @stop
    @endif

@section('content')

<section id="main-banner" class="section">
    @include('index.components.banner-principal')
</section>
<section id="como-funciona" class="section">
    @include('index.components.como-funciona')
</section>

<section id="mensalidade" class="section">
    @include('index.components.mensalidade')
</section>

<section id="duvidas" class="section">
    @include('index.components.duvidas')
</section>


<div class="clearfix"></div>
@stop
