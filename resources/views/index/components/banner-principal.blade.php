<img class="background-img" src="{{url(public_path('images/banner.jpg'))}}"/>
<div class="banner-content">
    <div class="banner-text">
        <p class="callout">Sua contabilidade agora ficou digital<br/>Acesse nossos serviços onde você estiver</p>
    </div>
    <div class="banner-buttons">
        @if(Auth::check())
            <a href="{{route('dashboard')}}" class="btn btn-lg btn-complete transparent">Acesse
                agora mesmo</a>
        @else
            <a href="" data-toggle="modal" data-target="#modal-access" class="btn btn-lg btn-complete transparent">Acesse
                agora mesmo</a>
        @endif
        <a href="" class="btn btn-lg btn-warning transparent">Conheça mais sobre nós</a>
    </div>
</div>
