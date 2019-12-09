<img class="background-img" src="{{url(public_path('images/banner.jpg'))}}"/>
<div class="banner-content">
    <div class="banner-text">
        <p class="callout hidden-xs">Contabilidade online para a sua empresa
        </p>
        <p class="callout visible-xs">Contabilidade online para sua empresa
        </p>
    </div>
    <div class="banner-buttons">
        @if(Auth::check())
            <a href="{{route('dashboard')}}" class="btn btn-lg btn-complete transparent">Acesse
                agora mesmo</a>
        @else
            <a href="" data-toggle="modal" data-target="#modal-access" class="btn btn-lg btn-complete transparent">Acesse
                agora mesmo</a>
        @endif

        <a href="#como-funciona" class="btn btn-lg btn-warning transparent page-scroll hidden-xs">Conheça nossos serviços</a>
        <div class="clearfix"></div>

        <a href="" data-toggle="modal" data-target="#modal-register"
           class="btn btn-lg text-center btn-success transparent visible-xs">Ou crie sua conta</a>
    </div>
</div>
