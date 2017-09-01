<div class="col-sm-6">
    <div class="form-group">
        <label for="sindicalizado">Sindicato *</label>
        <select name="contrato[sindicalizado]" class="form-control" id="sindicalizado">
            <option>Escolha uma opção</option>
            <option {{$contrato->sindicalizado ? 'selected="selected"' : ''}} value="1">Sim</option>
            <option {{!$contrato->sindicalizado ? 'selected="selected"' : ''}} value="0">Não</option>
        </select>
    </div>
</div>
<div id="info-sindicato" {{$contrato->sindicalizado ? '' : 'style="display: none"'}}>
    <div class="col-xs-6">
        <div class="form-group">
            <label for="sindicato">Nome do sindicato *</label>
            <input type="text" class="form-control" value="{{$contrato->sindicato}}" name="contrato[sindicato]"
                   disabled="disabled"/>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <label for="competencia_sindicato">Data da última contribuição</label>
            <input type="text" class="form-control date-mask"
                   value="{{$contrato->competencia_sindicato ? $contrato->competencia_sindicato->format('d/m/Y') : ''}}" name="contrato[competencia_sindicato]"
                   disabled="disabled"/>
        </div>
    </div>
</div>