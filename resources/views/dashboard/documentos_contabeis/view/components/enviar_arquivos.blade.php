<form id="form-principal" method="POST" action="">
<table class="table table-striped table-hover" data-referencia-id="{{$processo->id}}">
    <tbody>
    <tr>
        <th>Extratos bancários (OFX)<br/><small>Se tiver mais de um extrato por favor enviar os OFXs
                em ZIP</small></th>
        @include('dashboard.documentos_contabeis.view.components.opcoes', ['descricao'=>'Extratos bancários (OFX)'])
    </tr>
    <tr>
        <th>Extratos bancários (PDF)<br/><small>Se tiver mais de um extrato por favor enviar os PDFs
                em ZIP</small></th>
        @include('dashboard.documentos_contabeis.view.components.opcoes', ['descricao'=>'Extratos bancários (PDF)'])
    </tr>
    <tr>
        <th>Relatório Financeiro<br/><small>Enviar um relatório financeiro explicando as
                movimentações bancárias e demais entradas e saídas de dinheiro no caixa</small></th>
        @include('dashboard.documentos_contabeis.view.components.opcoes', ['descricao'=>'Relatório Financeiro'])
    </tr>
    @if($processo->empresa->hasFolha($processo->periodo))
        <tr>
            <th>Comprovante de pagamento de INSS (GPS)</th>
            @include('dashboard.documentos_contabeis.view.components.opcoes', ['descricao'=>'Comprovante de pagamento de INSS (GPS)'])
        </tr>
        <tr>
            <th>Comprovante de pagamento de FGTS</th>
            @include('dashboard.documentos_contabeis.view.components.opcoes', ['descricao'=>'Comprovante de pagamento de FGTS'])
        </tr>
        @if($processo->empresa->funcionarios()->count() > 0)
            <tr>
                <th>Comprovante de pagamento de Folha</th>
                @include('dashboard.documentos_contabeis.view.components.opcoes', ['descricao'=>'Comprovante de pagamento de Folha'])
            </tr>
        @endif
        <tr>
            <th>Comprovante de pagamento de Pró-labore</th>
            @include('dashboard.documentos_contabeis.view.components.opcoes', ['descricao'=>'Comprovante de pagamento de Pró-labore'])
        </tr>
    @endif
    @if($processo->empresa->hasSimplesNacional($processo->periodo))
        <tr>
            <th>Comprovante de pagamento do Simples Nacional<br/><small>Enviar o comprovante de
                    pagamento do Simples Nacional em PDF ou foto</small></th>
            @include('dashboard.documentos_contabeis.view.components.opcoes', ['descricao'=>'Comprovante de pagamento do Simples Nacional'])
        </tr>
    @endif
    <tr>
        <th>Aluguel/Água/Luz/Telefone/Internet<br/><small>Enviar os comprovante de pagamento em um arquivo ZIP</small>
        </th>
        @include('dashboard.documentos_contabeis.view.components.opcoes', ['descricao'=>'Aluguel/Água/Luz/Telefone/Internet'])
    </tr>
    <tr>
        <th>Outros recibos<br/><small>Enviar os demais comprovantes e recibos em um arquivo
                ZIP</small></th>
        @include('dashboard.documentos_contabeis.view.components.opcoes', ['descricao'=>'Outros recibos'])
    </tr>
    </tbody>
</table>
</form>