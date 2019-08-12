@if(Route::current()->getPrefix() != '/dashboard/reunioes')
<script type="text/javascript">
            setInterval(function () {
                $('.fa.fa-calendar-o').parent().toggleClass('shake')
            }, 3000)
    </script>
@endif
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
            <a class="{{Route::currentRouteNamed('dashboard') ? 'active' : ''}}"
               href="{{route('dashboard')}}"><span
                        class="fa fa-home"></span> Início <i class="fa fa-angle-right"></i></a>
        </li>
        <li><a class="{{Route::current()->getPrefix() == '/dashboard/reunioes' ? 'active':'animated shake highlight'}}"
               href="{{route('listReunioesToUser')}}"><span class="fa fa-calendar-o"></span> Reuniões (Novo)<i
                        class="fa fa-angle-right"></i></a></li>
        <li>
            <a class="{{Route::current()->uri != 'dashboard/apuracao/calendario' && Route::current()->getPrefix() == '/dashboard/apuracao' ? 'active':''}}"
               href="{{route('listApuracoesToUser')}}"><span class="fa fa-calendar-check-o"></span> Apurações/Envio de
                Notas {!!Auth::user()->hasApuracoesPendentes() ? '<span class="badge">'.Auth::user()->qtdApuracoesPendentes().'</span>':''!!}
                <i class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/dashboard/atendimento' ? 'active':''}}"
               href="{{route('listAtendimentosToUser')}}"><span class="fa fa-comments"></span> Atendimento <i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/dashboard/certificados-digitais' ? 'active':''}}"
               href="{{route('listCertificadosToUser')}}"><span class="fa fa-id-card"></span> Certificados Digitais<i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->uri == 'dashboard/apuracao/calendario' ? 'active':''}}"
               href="{{route('showCalendarioImpostos')}}"><span class="fa fa-calendar"></span> Calendário de impostos <i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/dashboard/documentos-contabeis' ? 'active':''}}"
               href="{{route('listDocumentosContabeisToUser')}}"><span class="fa fa-files-o"></span> Documentos
                contábeis {!!Auth::user()->hasDocumentosContabeisPendentes() ? '<span class="badge">'.Auth::user()->qtdDocumentosContabeisPendentes().'</span>':''!!}
                <i class="fa fa-angle-right"></i></a></li>
        <li>
            <a href=""><span class="fa fa-building"></span> Empresas <i class="fa fa-angle-down"></i></a>
            <ul class="left-menu-list animated fadeInLeft">
                <li><a class="{{Route::current()->getPrefix() == '/dashboard/abertura-empresa' ? 'active':''}}"
                       href="{{route('listAberturaEmpresaToUser')}}">Abertura de empresa <i
                                class="fa fa-angle-right"></i></a></li>
                <li><a class="{{Route::current()->getPrefix() == '/dashboard/empresas' ? 'active':''}}"
                       href="{{route('listEmpresaToUser')}}">Listar/Migrar empresa <i class="fa fa-angle-right"></i></a>
                </li>
                <li><a class="{{Route::current()->getPrefix() == '/dashboard/solicitar-alteracao' ? 'active':''}}"
                       href="{{route('chooseEmpresaSolicitacaoAlteracao')}}">Solicitações de Alteração <i
                                class="fa fa-angle-right"></i></a></li>
            </ul>
        </li>

        <li>
            <a href=""><span class="fa fa-users"></span> Gestão de Pessoas <i class="fa fa-angle-down"></i></a>
            <ul class="left-menu-list animated fadeInLeft">
                <li><a class="{{Route::current()->getPrefix() == '/dashboard/processamento-folha' ? 'active':''}}"
                       href="{{route('listProcessoFolhaToUser')}}">Apurações/Folha <i class="fa fa-angle-right"></i></a>
                </li>
                <li><a class="{{Route::current()->getPrefix() == '/dashboard/funcionarios' ? 'active':''}}"
                       href="{{route('listFuncionarioToUser')}}">Funcionários <i class="fa fa-angle-right"></i></a></li>
                <li><a class="{{Route::current()->getPrefix() == '/dashboard/demissao' ? 'active':''}}"
                       href="{{route('listDemissaoToUser')}}">Demissões <i class="fa fa-angle-right"></i></a></li>
                <li><a class="{{Route::current()->getPrefix() == '/dashboard/decimo-terceiro' ? 'active':''}}"
                       href="{{route('listDecimoTerceiroToUser')}}">Décimo Terceiro <i
                                class="fa fa-angle-right"></i></a></li>
                <li><a class="{{Route::current()->getPrefix() == '/dashboard/pontos' ? 'active':''}}"
                       href="{{route('listPontosToUser')}}">Registro de Ponto <i class="fa fa-angle-right"></i></a></li>
            </ul>
        </li>
        <li><a class="{{Route::current()->getPrefix() == '/dashboard/imposto-renda' ? 'active':''}}"
               href="{{route('listImpostoRendaToUser')}}"><span class="fa fa-paw"></span> Imposto de Renda <i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/dashboard/pagamentos' ? 'active':''}}"
               href="{{route('listOrdensPagamentoToUser')}}"><span class="fa fa-credit-card"></span>
                Pagamentos {!!Auth::user()->hasPagamentosPendentes() ? '<span class="badge">'.Auth::user()->qtdPagamentosPendentes().'</span>':''!!}
                <i
                        class="fa fa-angle-right"></i></a></li>
        <li><a class="{{Route::current()->getPrefix() == '/dashboard/recalculos' ? 'active':''}}"
               href="{{route('listRecalculosToUser')}}"><span class="fa fa-repeat"></span> Recálculos <i
                        class="fa fa-angle-right"></i></a></li>

        <li>
            <a href=""><span class="fa fa-file-text"></span> Relatórios <i class="fa fa-angle-down"></i></a>
            <ul class="left-menu-list animated fadeInLeft">
                <li><a class="{{Route::current()->getPrefix() == '/dashboard/balancetes' ? 'active':''}}"
                       href="{{route('listBalancetesToUser')}}">Balancetes <i class="fa fa-angle-right"></i></a>
                </li>
            </ul>
        </li>
    </ul>
</div>