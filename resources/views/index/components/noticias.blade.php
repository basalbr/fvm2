<div class="container">
    <div class="col-xs-12">
        <h1 class="hidden-xs">Últimas novidades</h1>
        <h1 class="visible-xs">Novidades</h1>
    </div>
    <div class="col-xs-12 hidden-xs">
        @foreach($noticias as $k=>$noticia)
            <div class="{{$k==0 ? 'destaque' : 'normal'}}">
                <a href="{{route('showNoticiaToUser', $noticia)}}">
                    <img src="{{$noticia->getCapaUrl($k==0 ? 'destaque' : 'normal')}}"/>
                    <div class="title">{{ $k==0 ? $noticia->titulo_destaque : $noticia->titulo}}</div>
                </a>
            </div>
        @endforeach
        <div class="clearfix"></div>
        <br/>
        <div class="text-center">
            <a href="{{route('listNoticiasToUser')}}" class="btn btn-lg btn-success transparent">Clique para ver todas
                as notícias</a>
        </div>
    </div>
    <div class="col-xs-12 visible-xs">
        @foreach($noticias as $noticia)
            <div class="normal">
                <a href="{{route('showNoticiaToUser', $noticia)}}">
                    <img src="{{$noticia->getCapaUrl('normal')}}"/>
                    <div class="title">{{$noticia->titulo}}</div>
                </a>
            </div>
        @endforeach
        <div class="clearfix"></div>
        <br/>
        <div class="text-center">
            <a href="{{route('listNoticiasToUser')}}" class="btn btn-lg btn-success transparent">Mostre-me mais</a>
        </div>
    </div>
</div>