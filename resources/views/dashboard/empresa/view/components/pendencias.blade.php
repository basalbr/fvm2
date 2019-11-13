<form id="form-principal" method="POST" action="">
    <p><strong>{{Auth::user()->nome}}, precisamos dos documentos abaixo o mais breve possível:</strong></p>
    <table class="table table-striped table-hover" data-referencia-id="{{$empresa->id}}">
        <tbody>
        @if($empresa->isPendente('Contrato Social/Requerimento de Empresário'))
            <tr>
                <th>Contrato Social/Requerimento de Empresário<br/><small>Enviar o contrato social ou requerimento de
                        empresário de sua empresa</small></th>
                @include('dashboard.empresa.view.components.opcoes', ['descricao'=>'Contrato Social/Requerimento de Empresário'])
            </tr>
        @endif
        @if($empresa->isPendente('Alterações Contratuais'))
            <tr>
                <th>Alterações Contratuais<br/><small>Enviar todas as alterações contratuais de sua empresa em PDF ou
                        ZIP</small></th>
                @include('dashboard.empresa.view.components.opcoes', ['descricao'=>'Alterações Contratuais'])
            </tr>
        @endif
        @if($empresa->isPendente('Última SEFIP/GFIP transmitida'))
            <tr>
                <th>Última SEFIP/GFIP transmitida<br/><small>Enviar a última SEFIP/GFIP transmitida pelo seu contador
                        anterior</small></th>
                @include('dashboard.empresa.view.components.opcoes', ['descricao'=>'Última SEFIP/GFIP transmitida'])
            </tr>
        @endif
        @if($empresa->isPendente('Ficha de registro de contribuintes e funcionários'))
            <tr>
                <th>Ficha de registro de contribuintes e funcionários<br/><small>Enviar a ficha de registro de
                        contribuintes e funcionários com anotações (alteração salarial, afastamentos, férias,
                        etc)</small></th>
                @include('dashboard.empresa.view.components.opcoes', ['descricao'=>'Ficha de registro de contribuintes e funcionários'])
            </tr>
        @endif
        @if($empresa->isPendente('Balancete'))
            <tr>
                <th>Balancete<br/><small>Enviar o balancete do último mês sob responsabilidade do contador
                        anterior</small></th>
                @include('dashboard.empresa.view.components.opcoes', ['descricao'=>'Balancete'])
            </tr>
        @endif
        </tbody>
    </table>
</form>