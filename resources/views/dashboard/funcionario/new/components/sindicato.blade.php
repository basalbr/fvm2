<div class="col-xs-12">
    <h3>Sindicato</h3>
    <hr>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="sindicalizado">Sindicato *</label>
        <select name="contrato[sindicalizado]" class="form-control" id="sindicalizado">
            <option>Escolha uma opção</option>
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
    </div>
</div>
<div id="info-sindicato" style="display: none">
    <div class="col-xs-6">
        <div class="form-group">
            <label for="sindicato">Nome do sindicato *</label>
            <input type="text" class="form-control" value="" name="contrato[sindicato]" disabled="disabled"/>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <label for="competencia_sindicato">Data da última contribuição</label>
            <input type="text" class="form-control date-mask" value="" name="contrato[competencia_sindicato]"
                   disabled="disabled"/>
        </div>
    </div>
</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar</button>
    <button class="btn btn-primary next">Avançar <i class="fa fa-angle-right"></i></button>
</div>