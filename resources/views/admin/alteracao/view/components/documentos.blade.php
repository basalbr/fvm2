<table class="table table-striped table-hover">
    @if($qtdeDocumentos > 0)
        @foreach($alteracao->informacoes as $informacao)
            @if($informacao->campo->tipo == 'file')
                <tr>
                    <th>{{$informacao->campo->nome}}</th>
                    <td>
                        <a download
                           href="{{asset(public_path().'storage/alteracao/'. $alteracao->id .'/'. $informacao->valor)}}"
                           title="Clique para fazer download do arquivo">Download</a>
                    </td>
                </tr>
            @endif
        @endforeach
        @foreach($alteracao->mensagens as $message)
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
            <td colspan="2" class="text-center"><a href="{{route('downloadZipApuracao', $alteracao->id)}}"
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