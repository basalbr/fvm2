<div class='anexo animated bounceIn'>
    <div class="big-icon">
        <span class="fa fa-file"></span>
        <a download class="download"
           href="{{asset('public/storage/anexos/'. $anexo->referencia . '/'.$anexo->id_referencia . '/' . $anexo->arquivo)}}"
           title="Clique para fazer download do arquivo"><i class="fa fa-download"></i></a>
    </div>
    <div class="description" title="{{$anexo->descricao}}">{{$anexo->descricao}}</div>
</div>
