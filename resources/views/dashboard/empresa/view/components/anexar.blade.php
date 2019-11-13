<td>
    <button class="btn btn-primary"><i class="fa fa-upload"></i> Enviar arquivo
    </button>
    <input type="file" data-name="{{$descricao}}" class="hidden link-input"
           data-upload-url="{{route('uploadFile')}}"/>
</td>