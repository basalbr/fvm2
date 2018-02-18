<div class="col-xs-12">
    <div class="form-group">
        <label>Valor da Doação</label>
        <input type="text" value="" placeholder="R$" name="doacao[descricao]" class="form-control money-mask"/>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label>Cópia de CPF e RG para quem foi feita a doação</label>
        <div class="form-control">
            <button class="btn btn-primary upload-file" data-tipo="doacao"><span
                        class="fa fa-upload"></span> Anexar Documento
            </button>
            <input type="file" class="hidden upload-input" data-upload-url="{{route('uploadTempFile')}}" name="doacao[documento]"/>
            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
        </div>
    </div>
</div>