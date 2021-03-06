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
            <a class="{{Route::currentRouteNamed('adminHome') ? 'active' : ''}}" href="{{route('adminHome')}}"><span
                        class="fa fa-home"></span> Início <i class="fa fa-angle-right"></i></a>
        </li>
        <li><a class="{{Route::current()->getPrefix() == '/admin/atendimento' ? 'active':''}}"
               href="{{route('listAtendimentosToAdmin')}}"><span class="fa fa-comments"></span> Atendimento <i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/admin/balancete' ? 'active':''}}"
               href="{{route('listBalancetesToAdmin')}}"><span class="fa fa-area-chart"></span> Balancetes <i
                        class="fa fa-angle-right"></i></a></li>
        @if(Auth::user()->id === 1)
            <li>
                <a href=""><span class="fa fa-file-archive-o"></span> Cadastros <i class="fa fa-angle-down"></i></a>
                <ul class="left-menu-list animated fadeInLeft">
                    <li><a class="{{Route::current()->getPrefix() == '/admin/cadastros/alteracao' ? 'active':''}}"
                           href="{{route('listCadastroAlteracao')}}">Alterações <i
                                    class="fa fa-angle-right"></i></a></li>
                    <li><a class="{{Route::current()->getPrefix() == '/admin/cadastros/recalculo' ? 'active':''}}"
                           href="{{route('listCadastroRecalculo')}}">Recálculos <i
                                    class="fa fa-angle-right"></i></a></li>
                </ul>
            </li>
        @endif
        <li>
            <a href=""><span class="fa fa-building"></span> Empresas <i class="fa fa-angle-down"></i></a>
            <ul class="left-menu-list animated fadeInLeft">
                <li><a class="{{Route::current()->getPrefix() == '/admin/abertura-empresa' ? 'active':''}}"
                       href="{{route('listAberturaEmpresaToAdmin')}}">Abertura de empresa <i
                                class="fa fa-angle-right"></i></a></li>
                <li><a class="{{Route::current()->getPrefix() == '/admin/empresas' ? 'active':''}}"
                       href="{{route('listEmpresaToAdmin')}}">Listar empresas <i class="fa fa-angle-right"></i></a></li>
                <li><a class="{{Route::current()->getPrefix() == '/admin/solicitar-alteracao' ? 'active':''}}"
                       href="{{route('listSolicitacoesAlteracaoToAdmin')}}">Solicitações de Alteração <i
                                class="fa fa-angle-right"></i></a></li>
            </ul>
        </li>
        <li>
        <li><a class="{{Route::current()->getPrefix() == '/admin/apuracao' ? 'active':''}}"
               href="{{route('listApuracoesToAdmin')}}"><span class="fa fa-calendar-check-o"></span> Listar apurações <i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/admin/documentos-contabeis' ? 'active':''}}"
               href="{{route('listDocumentosContabeisToAdmin')}}"><span class="fa fa-files-o"></span> Documentos
                contábeis <i class="fa fa-angle-right"></i></a></li>

        <li>
            <a href=""><span class="fa fa-users"></span> Gestão de Pessoas <i class="fa fa-angle-down"></i></a>
            <ul class="left-menu-list animated fadeInLeft">
                <li><a class="{{Route::current()->getPrefix() == '/admin/funcionarios' ? 'active':''}}"
                       href="{{route('listFuncionarioToAdmin')}}">Funcionários <i class="fa fa-angle-right"></i></a>
                </li>
                <li><a class="{{Route::current()->getPrefix() == '/admin/demissao' ? 'active':''}}"
                       href="{{route('listDemissaoToAdmin')}}">Demissões <i class="fa fa-angle-right"></i></a></li>
                <li><a class="{{Route::current()->getPrefix() == '/admin/decimo-terceiro' ? 'active':''}}"
                       href="{{route('listDecimoTerceiroToAdmin')}}">Décimo Terceiro <i
                                class="fa fa-angle-right"></i></a></li>
                <li><a class="{{Route::current()->getPrefix() == '/admin/pontos' ? 'active':''}}"
                       href="{{route('listPontosToAdmin')}}">Registro de Ponto <i class="fa fa-angle-right"></i></a>
                </li>
                <li><a class="{{Route::current()->getPrefix() == '/admin/processamento-folha' ? 'active':''}}"
                       href="{{route('listProcessoFolhaToAdmin')}}">Apurações <i class="fa fa-angle-right"></i></a></li>
                <li><a class="{{Route::current()->getPrefix() == '/admin/alteracao-contratual' ? 'active':''}}"
                       href="{{route('listAlteracaoContratualToAdmin')}}">Alterações Contratuais <i
                                class="fa fa-angle-right"></i></a></li>
            </ul>
        </li>
        <li><a class="{{Route::current()->getPrefix() == '/admin/imposto-renda' ? 'active':''}}"
               href="{{route('listImpostoRendaToAdmin')}}"><span class="fa fa-paw"></span> Impostos de Renda <i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/admin/pagamentos' ? 'active':''}}"
               href="{{route('listOrdensPagamentoToAdmin')}}"><span class="fa fa-credit-card"></span> Pagamentos <i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/admin/recalculos' ? 'active':''}}"
               href="{{route('listRecalculosToAdmin')}}"><span class="fa fa-repeat"></span> Recálculos <i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/admin/reunioes' ? 'active':''}}"
               href="{{route('listReunioesToAdmin')}}"><span class="fa fa-calendar-o"></span> Reuniões <i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/admin/tarefas' ? 'active':''}}"
               href="{{route('listTarefasToAdmin')}}"><span class="fa fa-tasks"></span> Tarefas <i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/admin/usuarios' ? 'active':''}}"
               href="{{route('listUsuariosToAdmin')}}"><span class="fa fa-user-circle"></span> Usuários <i
                        class="fa fa-angle-right"></i></a></li>
    </ul>
</div>