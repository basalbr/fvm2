<div class="alert alert-info" style="display: block">
    <p><strong>Abaixo os arquivos tramitados nesse processo.</strong> Para realizar o download dos arquivos basta clicar no nome do arquivo</p>
</div>
<div class="clearfix"></div>
<table class="table table-striped table-hover">
    @if($qtdeDocumentos > 0)
        @foreach($aberturaEmpresa->mensagens as $message)
            @if($message->anexo)
                <tr>
                    <th class="visible-xs"><a href="{{$message->anexo->getHref()}}" target="_blank">{{$message->anexo->descricao}}</a></th>
                    <th class="hidden-xs">{{$message->anexo->descricao}}</th>
                    <td class="hidden-xs">
                        {!! $message->anexo->getLink() !!}
                    </td>
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td class="text-center">Nenhum documento enviado</td>
        </tr>
    @endif
    <tbody>
</table>
<div class="clearfix"></div>