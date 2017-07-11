<form method="POST" action="" id="form-principal" enctype="multipart/form-data">
    {{ csrf_field() }}
    @include('admin.components.form-alert')
    <div id="anexos">
        <div class="col-sm-12">
            <p>Aqui estão os arquivos relacionados à esse processo.</p>
        </div>
        <div class="list">
            @foreach($processo->anexos as $anexo)
                <div class="col-sm-4">
                    @include('admin.components.anexo.withDownload', ['anexo'=>$anexo])
                </div>
            @endforeach
            @foreach($processo->mensagens as $message)
                @if($message->anexo)
                    <div class="col-sm-4">
                        @include('admin.components.anexo.withDownload', ['anexo'=>$message->anexo])
                    </div>
                @endif
            @endforeach
        </div>
        <div class="clearfix"></div>
    </div>
</form>
