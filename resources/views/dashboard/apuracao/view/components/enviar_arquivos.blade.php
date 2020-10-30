<form id="form-principal" method="POST" action="">
    <table class="table table-striped table-hover" data-referencia-id="{{$apuracao->id}}">
        <tbody>
        <tr>
            <th colspan="2">
                <div class="label label-success">Notas fiscais de saída de mercadorias e serviços</div>
            </th>
        </tr>
        <tr>
            <th>Saída de mercadorias (XML)<br/><small>Se tiver mais de uma nota fiscal por favor enviar os XMLs
                    em um único arquivo ZIP</small></th>
            @include('dashboard.apuracao.view.components.opcoes', ['descricao'=>'Saída de mercadorias (XML)'])
        </tr>
        <tr>
            <th>Saída de mercadorias (PDF)<br/><small>Se tiver mais de uma nota fiscal por favor enviar os PDFs
                    em um único arquivo ZIP</small></th>
            @include('dashboard.apuracao.view.components.opcoes', ['descricao'=>'Saída de mercadorias (PDF)'])
        </tr>
        <tr>
            <th>Prestação de serviços (XML)<br/><small>Se tiver mais de uma nota fiscal por favor enviar os XMLs
                    em um único arquivo ZIP</small></th>
            @include('dashboard.apuracao.view.components.opcoes', ['descricao'=>'Prestação de serviços (XML)'])
        </tr>
        <tr>
            <th>Prestação de serviços (PDF)<br/><small>Se tiver mais de uma nota fiscal por favor enviar os PDFs
                    em um único arquivo ZIP</small></th>
            @include('dashboard.apuracao.view.components.opcoes', ['descricao'=>'Prestação de serviços (PDF)'])
        </tr>
        <tr>
            <th>Redução Z (TXT)<br/><small>Enviar o arquivo Sintegra da redução Z (em TXT)</small></th>
            @include('dashboard.apuracao.view.components.opcoes', ['descricao'=>'Redução Z (TXT)'])
        </tr>
        <tr>
            <th colspan="2">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" name="has_retencao_saida" value="1"><span></span> Possui notas de saída com
                    retenção de impostos<br/><small>Marque se alguma nota de saída de mercadoria ou prestação de serviço estiver com retenção de impostos de qualquer natureza</small>
                </label>
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <div class="label label-success">Notas fiscais de entrada de mercadorias e serviços</div>
            </th>
        </tr>
        <tr>
            <th>Entrada de mercadorias (XML)<br/><small>Se tiver mais de uma nota fiscal por favor enviar os XMLs
                    em um único arquivo ZIP</small></th>
            @include('dashboard.apuracao.view.components.opcoes', ['descricao'=>'Entrada de mercadorias (XML)'])
        </tr>
        <tr>
            <th>Entrada de mercadorias (PDF)<br/><small>Se tiver mais de uma nota fiscal por favor enviar os PDFs
                    em um único arquivo ZIP</small></th>
            @include('dashboard.apuracao.view.components.opcoes', ['descricao'=>'Entrada de mercadorias (PDF)'])
        </tr>

        <tr>
            <th>Aquisição de serviços (XML)<br/><small>Se tiver mais de uma nota fiscal por favor enviar os XMLs
                    em um único arquivo ZIP</small></th>
            @include('dashboard.apuracao.view.components.opcoes', ['descricao'=>'Aquisição de serviços (XML)'])
        </tr>
        <tr>
            <th>Aquisição de serviços (PDF)<br/><small>Se tiver mais de uma nota fiscal por favor enviar os PDFs
                    em um único arquivo ZIP</small></th>
            @include('dashboard.apuracao.view.components.opcoes', ['descricao'=>'Aquisição de serviços (PDF)'])
        </tr>
        <tr>
            <th colspan="2">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" name="has_retencao_entrada" value="1"><span></span> Possui notas de entrada com
                    retenção de impostos<br/><small>Marque se alguma nota de entrada de mercadoria ou de aquisição de serviço estiver com retenção de impostos de qualquer natureza</small>
                </label>
            </th>
        </tr>
        </tbody>
    </table>
</form>