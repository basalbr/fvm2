@extends('layouts.master')

@section('meta')
    <meta property="og:locale" content="pt_BR">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{$noticia->titulo}}">
    <meta property="og:description" content="{{$noticia->subtitulo}}">
    <meta property="og:url" content="{{route('showNoticiaToUser', $noticia)}}">
    <meta property="og:image:width" content="750">
    <meta property="og:image:height" content="350">
    <meta property="fb:app_id" content="117365205640186">
    <meta property="og:site_name" content="WEBContabilidade">
    <meta property="article:tag" content="Contabilidade">
    <meta property="article:tag" content="Contabilidade Online">
    <meta property="article:tag" content="Empreendedorismo">
    <meta property="article:published_time" content="{{$noticia->data_publicacao->format('Y-m-d')}}T10:00:00-03:00">
    <meta property="og:image" content="{{$noticia->getCapaUrl('normal')}}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:description" content="{{$noticia->subtitulo}}">
    <meta name="twitter:title" content="{{$noticia->titulo}}">
    <meta name="twitter:image" content="{{$noticia->getCapaUrl('normal')}}">
    <title>{{$noticia->titulo}}</title>
    <meta name="description"
          content="{{$noticia->subtitulo}}">
@stop
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
            @if(\Illuminate\Support\Facades\App::environment('production'))
            <div class="addthis_inline_share_toolbox"></div>
            @endif
            <div class="clearfix"></div>
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
