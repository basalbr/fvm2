<div id="anexos">
    <div class="list">
        @foreach($apuracao->informacoes as $informacao)
            @if($informacao->tipo->tipo == 'anexo')
                <div class="col-sm-4">
                    @include('admin.components.anexo.withDownload', ['anexo'=>$informacao->toAnexo()])
                </div>
            @endif
        @endforeach
        @foreach($apuracao->anexos as $anexo)
            <div class="col-sm-4">
                @include('admin.components.anexo.withDownload', ['anexo'=>$anexo])
            </div>
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
