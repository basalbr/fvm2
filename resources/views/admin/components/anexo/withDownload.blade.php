<div class='anexo animated bounceIn'>
    <div class="big-icon">
        <span class="fa fa-file"></span>
        <a download class="download"
           href="{{asset(public_path().'storage/anexos/'. $anexo->referencia . '/'.$anexo->id_referencia . '/' . $anexo->arquivo)}}"
           title="Clique para fazer download do arquivo"><i class="fa fa-download"></i></a>
    </div>
    @if(isset($anexo->valor))
        <div class="description" title="{{$anexo->valor}}">{{$anexo->valor}}</div>
    @else
        <div class="description" title="{{$anexo->descricao}}">{{$anexo->descricao}}</div>
    @endif
</div>
