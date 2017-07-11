<div id="anexos">
    <div class="list">
        @if($chamado->anexos)
            @foreach($chamado->anexos as $anexo)
                <div class="col-sm-4">
                    @include('admin.components.anexo.withDownload', ['anexo'=>$anexo])
                </div>
            @endforeach
        @endif
        @foreach($chamado->mensagens as $message)
            @if($message->anexo)
                <div class="col-sm-4">
                    @include('admin.components.anexo.withDownload', ['anexo'=>$message->anexo])
                </div>
            @endif
        @endforeach
    </div>
    <div class="clearfix"></div>
</div>