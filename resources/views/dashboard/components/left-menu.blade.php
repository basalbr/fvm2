<div id="left-menu">
    <div class="profile">
        <a href="">
            <div class="profile-pic"><img
                        src="https://images.mic.com/0hg7fwagt8yo80cqfdisukrxucvtzv00yaarqmzaj9aj4krhhpprfaqvjbst6tbz.jpg"/>
            </div>
            <div class="profile-name">Olá {{Auth::user()->getFirstName()}}!</div>
            <div class="profile-settings">Clique para editar seu perfil</div>
        </a>
    </div>
    <ul>
        <li>
            <a class="{{Route::currentRouteNamed('dashboard') ? 'active' : ''}}" href="{{route('dashboard')}}"><span class="fa fa-home"></span> Início <i class="fa fa-angle-right"></i></a>
        </li>
        <li>
            <a href=""><span class="fa fa-building"></span> Empresas <i class="fa fa-angle-down"></i></a>
            <ul id="left-menu-list" class="animated fadeInLeft">
                <li><a href="{{route('listAberturaEmpresaToUser')}}">Abertura de empresa <i class="fa fa-angle-right"></i></a></li>
                <li><a href="{{route('listEmpresaToUser')}}">Listar/Migrar empresa <i class="fa fa-angle-right"></i></a></li>
                <li><a href="{{route('listFuncionarioToUser')}}">Funcionários <i class="fa fa-angle-right"></i></a></li>
                <li><a href="">Sócios <i class="fa fa-angle-right"></i></a></li>
            </ul>
        </li>
        <li><a href=""><span class="fa fa-dollar"></span> Impostos <i class="fa fa-angle-down"></i></a></li>
        <li><a href=""><span class="fa fa-money"></span> Financeiro <i class="fa fa-angle-down"></i></a></li>
        <li><a href=""><span class="fa fa-credit-card"></span> Pagamentos <i class="fa fa-angle-right"></i></a></li>
        <li><a href=""><span class="fa fa-bullhorn"></span> Solicitações <i class="fa fa-angle-right"></i></a></li>
        <li><a href=""><span class="fa fa-comments"></span> Atendimento <i class="fa fa-angle-right"></i></a></li>
    </ul>
</div>