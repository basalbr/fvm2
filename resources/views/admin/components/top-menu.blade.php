<div id="top-title" class="animated slideInDown">
    <i class="fa fa-map-signs"></i> @yield('top-title')
</div>
<div id="top-menu">
    <button type="button" id="open-left-menu"><i class="fa fa-bars"></i> menu</button>
    <div id="top-menu-brand"><img src="{{url(public_path().'images/logotipo-pequeno.png')}}"/></div>
    <ul id="top-menu-items">
        <li><a href="{{route('logout')}}"><span class="fa fa-sign-out"></span> Sair</a></li>
    </ul>
</div>
