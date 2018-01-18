<div class="col-xs-12">
    <div class="form-group">
        <label>Selecione o tipo de documento</label>
        <select class="form-control" name="{{$referencia}}[descricao]">
            @foreach($opcoes as $opcao)
                <option value="{{$opcao->descricao}}">{{$opcao->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label>Envie o documento comprobatório</label>
        <div class="form-control">
            <button class="btn btn-primary upload-file" data-tipo="{{$referencia}}"><span
                        class="fa fa-upload"></span>
                Anexar Documento
            </button>
            <input type="file" data-upload-url="{{route('uploadTempFile')}}" class="hidden upload-input" name="{{$referencia}}[documento]"/>
            <p class="help-block">Formatos aceitos: .pdf .jpeg .png. Tamanho Máximo: 10MB</p>
        </div>
    </div>
</div>
