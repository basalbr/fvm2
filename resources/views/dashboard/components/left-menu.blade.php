<div id="left-menu">
    <div class="profile">
        <a href="{{route('editPerfil')}}">
            <div class="profile-pic"><img
                        src="{{Auth::user()->foto ? asset('public/storage/usuarios/'.Auth::user()->id.'/'.Auth::user()->foto) : asset(public_path().'images/thumb.jpg')}}"/>
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
            </ul>
        </li>
        <li>
            <a href=""><span class="fa fa-calendar-check-o"></span> Apurações <i class="fa fa-angle-down"></i></a>
            <ul id="left-menu-list" class="animated fadeInLeft">
                <li><a href="{{route('showCalendarioImpostos')}}">Calendário de impostos <i class="fa fa-angle-right"></i></a></li>
                <li><a href="{{route('listApuracoesToUser')}}">Listar apurações <i class="fa fa-angle-right"></i></a></li>
            </ul>
        </li>
        <li><a href="{{route('listDocumentosContabeisToUser')}}"><span class="fa fa-files-o"></span> Documentos contábeis <i class="fa fa-angle-right"></i></a></li>
        <li><a href="{{route('listOrdensPagamentoToUser')}}"><span class="fa fa-credit-card"></span> Pagamentos <i class="fa fa-angle-right"></i></a></li>
        <li><a href="{{route('listSolicitacoesAlteracaoToUser')}}"><span class="fa fa-bullhorn"></span> Solicitações de Alteração <i class="fa fa-angle-right"></i></a></li>
        <li><a href="{{route('listAtendimentosToUser')}}"><span class="fa fa-comments"></span> Atendimento <i class="fa fa-angle-right"></i></a></li>
    </ul>
</div>