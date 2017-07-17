<div id="anexos">
    <div class="col-sm-12">
        <p>Aqui estão os arquivos relacionados à esse processo.</p>
    </div>
    <div class="list">
        @if(count($alteracao->informacoes))
            @foreach($alteracao->informacoes as $anexo)
                @if($anexo->campo->tipo == 'file')
                    <div class="col-sm-4">
                        @include('admin.components.anexo.withDownload', ['anexo'=>$anexo])
                    </div>
                @endif
            @endforeach
        @endif
        @foreach($alteracao->mensagens as $message)
            @if($message->anexo)
                <div class="col-sm-4">
                    @include('admin.components.anexo.withDownload', ['anexo'=>$message->anexo])
                </div>
            @endif
        @endforeach
    </div>
</div>
<div class="clearfix"></div>