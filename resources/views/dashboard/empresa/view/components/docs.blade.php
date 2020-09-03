<div class="alert alert-info" style="display: block">
    <p><strong>Abaixo todos os documentos</strong> que foram enviados nessa página.</p>
</div>
<table class="table table-striped table-hover">
    <tbody>
    @if($qtdeDocumentos > 0)
    @foreach($empresa->anexos as $anexo)
        <tr>
            <th>{{$anexo->descricao}}</th>
            <td>
                {!! $anexo->getLink() !!}
            </td>
        </tr>
    @endforeach
    @foreach($empresa->mensagens as $message)
        @if($message->anexo)
            <tr>
                <th>{{$message->anexo->descricao}}</th>
                <td>
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
    </tbody>
</table>