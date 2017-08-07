<div id="left-menu">
    <div class="profile">
        <a href="{{route('editPerfil')}}">
            <div class="profile-pic"><img
                        src="{{Auth::user()->foto ? asset(public_path().'storage/usuarios/'.Auth::user()->id.'/'.Auth::user()->foto) : asset(public_path().'images/thumb.jpg')}}"/>
            </div>
            <div class="profile-name">Olá {{Auth::user()->getFirstName()}}!</div>
            <div class="profile-settings">Clique para editar seu perfil</div>
        </a>
    </div>
    <ul>
        <li>
            <a class="{{Route::currentRouteNamed('adminHome') ? 'active' : ''}}" href="{{route('adminHome')}}"><span class="fa fa-home"></span> Início <i class="fa fa-angle-right"></i></a>
        </li>
        <li><a href="{{route('listAtendimentosToAdmin')}}"><span class="fa fa-comments"></span> Atendimento <i class="fa fa-angle-right"></i></a></li>

        <li><a href="{{route('listChatToAdmin')}}"><span class="fa fa-comment"></span> Chat <i class="fa fa-angle-right"></i></a></li>
        <li>
            <a href=""><span class="fa fa-building"></span> Empresas <i class="fa fa-angle-down"></i></a>
            <ul id="left-menu-list" class="animated fadeInLeft">
                <li><a href="{{route('listAberturaEmpresaToAdmin')}}">Abertura de empresa <i class="fa fa-angle-right"></i></a></li>
                <li><a href="{{route('listEmpresaToAdmin')}}">Listar/Migrar empresa <i class="fa fa-angle-right"></i></a></li>
                <li><a href="{{route('listFuncionarioToAdmin')}}">Funcionários <i class="fa fa-angle-right"></i></a></li>
                <li><a href="{{route('listSolicitacoesAlteracaoToAdmin')}}">Solicitações de Alteração <i class="fa fa-angle-right"></i></a></li>
            </ul>
        </li>
        <li>
            <a href=""><span class="fa fa-calendar-check-o"></span> Apurações <i class="fa fa-angle-down"></i></a>
            <ul id="left-menu-list" class="animated fadeInLeft">
                <li><a href="{{route('listApuracoesToAdmin')}}">Listar apurações <i class="fa fa-angle-right"></i></a></li>
            </ul>
        </li>
        <li><a href="{{route('listDocumentosContabeisToAdmin')}}"><span class="fa fa-files-o"></span> Documentos contábeis <i class="fa fa-angle-right"></i></a></li>

        <li>
            <a href=""><span class="fa fa-users"></span> Gestão de Pessoas <i class="fa fa-angle-down"></i></a>
            <ul id="left-menu-list" class="animated fadeInLeft">
                <li><a href="{{route('listProcessoFolhaToAdmin')}}">Apurações <i class="fa fa-angle-right"></i></a></li>
            </ul>
        </li>
        <li><a href="{{route('listOrdensPagamentoToAdmin')}}"><span class="fa fa-credit-card"></span> Pagamentos <i class="fa fa-angle-right"></i></a></li>


        <li><a href="{{route('listUsuariosToAdmin')}}"><span class="fa fa-user-circle"></span> Usuários <i class="fa fa-angle-right"></i></a></li>
    </ul>
</div>