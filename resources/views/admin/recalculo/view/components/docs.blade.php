<div id="anexos">
    <div class="col-sm-12">
        <p class="alert-info alert" style="display: block">Abaixo estão os arquivos enviados nas mensagens</p>
    </div>
    <div class="list">
        @foreach($recalculo->mensagens as $message)
            @if($message->anexo)
                <div class="col-sm-4">
                    @include('admin.components.anexo.withDownload', ['anexo'=>$message->anexo])
                </div>
            @endif
        @endforeach
    </div>
</div>
<div class="clearfix"></div>