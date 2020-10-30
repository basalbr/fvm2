<td>
    <a class="btn btn-success" href="{{asset(public_path().'storage/anexos/apuracao/'.$anexo->id_referencia . '/' . $anexo->arquivo)}}" download target="_blank"><i class="fa fa-download"></i> Download</a>
    <button class="btn btn-danger" data-url="{{route('removeDocumentoApuracao',[$apuracao->id, $anexo->id])}}" ><i class="fa fa-trash"></i> Remover arquivo</button>
    <input type="file" data-name="{{$descricao}}" class="hidden link-input"
           data-upload-url="{{route('uploadFile')}}"/>
</td>