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
        <div class="col-sm-4 hidden-xs">
            <h2>Últimas novidades</h2>
            <hr>
            <div class="ultimas">
                @foreach($noticias as $k => $nt)
                        <a href="{{route('showNoticiaToUser', $nt)}}">
                            <img src="{{$nt->getCapaUrl('normal')}}"/>
                            <div class="title">{{ $nt->titulo}}</div>
                        </a>
                @endforeach
            </div>
            <a class="btn btn-primary btn-block" href="{{route('listNoticiasToUser')}}">Quero ver mais</a>
        </div>
        <div class="col-sm-8 noticia">
            <h2>{{$noticia->titulo}}</h2>
            <h3>{{$noticia->subtitulo}}</h3>
            <div class="enviado">Enviado em {{$noticia->data_publicacao->format('d/m/Y')}}</div>
            <hr>
            <div>{!! $noticia->conteudo !!}</div>
        </div>
        <div class="visible-xs col-xs-12">
            <h2>Novidades</h2>
            <hr>
            <div class="ultimas">
                @foreach($noticias as $k => $nt)
                    <a href="{{route('showNoticiaToUser', $nt)}}">
                        <img src="{{$nt->getCapaUrl('normal')}}"/>
                        <div class="title">{{ $nt->titulo}}</div>
                    </a>
                @endforeach
            </div>
            <a class="btn btn-primary btn-block" href="{{route('listNoticiasToUser')}}">Quero ver mais</a>
        </div>
        <div class="clearfix"></div>
    </section>
@stop
