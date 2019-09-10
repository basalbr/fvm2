<table class="table table-striped table-hover">
    @if($qtdeDocumentos > 0)
        @foreach($apuracao->informacoes as $informacao)
            @if($informacao->tipo->tipo == 'anexo')
                <tr>
                    <th>{{$informacao->tipo->tipo->nome}}</th>
                    <td>
                        {!! $informacao->getLink() !!}
                    </td>
                </tr>
            @endif
        @endforeach
        @foreach($apuracao->anexos as $anexo)
            <tr>
                <th>{{$anexo->descricao}}</th>
                <td>
                    {!! $anexo->getLink() !!}
                </td>
            </tr>
        @endforeach
        @foreach($apuracao->mensagens as $message)
            @if($message->anexo)
                <tr>
                    <th>{{$message->anexo->descricao}}</th>
                    <td>
                        {!! $message->anexo->getLink() !!}
                    </td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td colspan="2" class="text-center"><a href="{{route('downloadZipApuracao', $apuracao->id)}}"
                                                   target="_blank">Baixar todos os arquivos em ZIP</a></td>
        </tr>
    @else
        <tr>
            <td class="text-center">Nenhum documento enviado</td>
        </tr>
    @endif
    <tbody>
</table>
<div class="clearfix"></div>