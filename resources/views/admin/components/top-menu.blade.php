<div id="top-menu">
    <button type="button" id="open-left-menu"><i class="fa fa-bars"></i> menu</button>
    <div id="top-menu-brand"><img src="{{url(public_path().'images/logotipo-pequeno.png')}}"/></div>
    <div id="top-title" class="slideInDown animated">
        <i class="fa fa-map-signs animated swing"></i> @yield('top-title')
    </div>
    <ul id="top-menu-items">
        @yield('add-task')
        @yield('annotations')
        <li><a href="{{route('logout')}}"><span class="fa fa-sign-out"></span> Sair</a></li>
    </ul>
</div>
