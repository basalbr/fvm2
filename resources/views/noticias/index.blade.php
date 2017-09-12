@extends('layouts.master')


@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#contrato').on('click', function () {
                $('#modal-contrato').modal('show');
            })
        })
    </script>
@stop


@section('content')
    <section id="noticia">
        <div class="col-xs-12">
            <h2>Todas as notícias</h2>
            <hr>
            <div class="todas">
                @foreach($noticias as $k => $nt)
                    <a class="col-sm-3" href="{{route('showNoticiaToUser', $nt)}}">
                        <img src="{{$nt->getCapaUrl('normal')}}"/>
                        <div class="title">{{ $nt->titulo}}</div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="clearfix"></div>
    </section>
@stop
