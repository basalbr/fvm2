<div id="nav-menu-brand"><img src="{{url(public_path('images/logo.png'))}}"/></div>
<ul id="nav-menu-items">
    <li><a class='page-scroll' href="#como-funciona">Como funciona</a></li>
    <li><a class='page-scroll' href="#imposto-renda">Imposto de Renda</a></li>
    <li><a class='page-scroll' href="#abertura-empresa">Abertura/Alteração</a></li>
    <li><a class='page-scroll' href="#mensalidade">Mensalidade</a></li>
    <li><a class='page-scroll' href="#noticias">Novidades</a></li>
    <li><a class='page-scroll' href="#duvidas">Dúvidas</a></li>
    <li><a class='page-scroll' href="#contato">Contato</a></li>
    @if(Auth::check())
        <li><a href="{{route('dashboard')}}" class="btn-registrar" data-toggle="modal"><span
                        class="fa fa-sign-in"></span> Acessar</a></li>
        <li><a href="{{route('logout')}}" class="btn-acessar" data-toggle="modal"><span class="fa fa-sign-out"></span>
                Sair</a></li>
    @else
        <li><a href="" class="btn-registrar" data-toggle="modal" data-target="#modal-register"><span
                        class="fa fa-check-square-o"></span> Crie sua conta</a></li>
        <li><a href="" class="btn-acessar" data-toggle="modal" data-target="#modal-access"><span
                        class="fa fa-sign-in"></span> Acessar</a></li>
    @endif
</ul>