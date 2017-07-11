
<div id="anexos">
    <br/>
    <div class="col-sm-12">
        <p>Aqui estão os arquivos relacionados à esse processo.</p>
    </div>
    <div class="list">
        @foreach($apuracao->informacoes as $informacao)
            @if($informacao->tipo->tipo == 'anexo')
                <div class="col-sm-4">
                    @include('admin.components.anexo.withDownload', ['anexo'=>$informacao->toAnexo()])
                </div>
            @endif
        @endforeach
        @foreach($apuracao->mensagens as $message)
            @if($message->anexo)
                <div class="col-sm-4">
                    @include('admin.components.anexo.withDownload', ['anexo'=>$message->anexo])
                </div>
            @endif
        @endforeach
    </div>
    <div class="clearfix"></div>
</div>
