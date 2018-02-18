<div class="col-xs-12">
    <div class="form-group">
        <label>Descrição do Documento</label>
        <input type="text" value="" name="outros[descricao]" class="form-control"/>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label>Documento comprobatório</label>
        <div class="form-control">
            <button class="btn btn-primary upload-file" data-tipo="outros"><span
                        class="fa fa-upload"></span> Enviar Documento
            </button>
            <input type="file" class="hidden upload-input" data-upload-url="{{route('uploadTempFile')}}" name="outros[documento]"/>
            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
        </div>
    </div>
</div>