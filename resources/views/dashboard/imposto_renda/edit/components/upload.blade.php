<div class="col-xs-12">
    <div class="form-group">
        <label>{{$descricao}}</label>
        <div class="form-control">
            <button class="btn btn-primary link-file"><span class="fa fa-upload"></span> Anexar
                Documento
            </button>
            <input type="file" data-name="{{$referencia}}" class="hidden link-input" data-upload-url="{{route('uploadTempFile')}}"/>
            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
        </div>
    </div>
</div>