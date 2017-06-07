<div class="col-xs-12">
    <h3>Contrato de Trabalho</h3>
    <hr>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="cargo">Cargo *</label>
        <input type="text" class="form-control" value="" name="cargo"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="funcao">Função *</label>
        <input type="text" class="form-control" value="" name="funcao"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="departamento">Departamento *</label>
        <input type="text" class="form-control" value="" name="departamento"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="id_categoria_contrato_trabalho">Categoria *</label>
        <select class="form-control" name="id_categoria_contrato_trabalho">
            <option value="">Selecione uma opção</option>
            @foreach($categoriasContrato as $categoria)
                <option value="{{$categoria->id}}">{{$categoria->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="id_vinculo_empregaticio">Vínculo empregatício *</label>
        <select class="form-control" name="id_vinculo_empregaticio">
            <option value="">Selecione uma opção</option>
            @foreach($vinculosEmpregaticios as $vinculoEmpregaticio)
                <option value="{{$vinculoEmpregaticio->id}}">{{$vinculoEmpregaticio->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-xs-6">
    <div class="form-group">
        <label for="salario">Salário (R$) *</label>
        <input type="text" class="form-control money-mask" value="" name="salario"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="data_admissao">Data de admissão *</label>
        <input type="text" class="form-control date-mask" value="" name="data_admissao"/>
    </div>
</div>


<div class="col-xs-6">
    <div class="form-group">
        <label for="id_situacao_seguro_desemprego">Situação do seguro desemprego *</label>
        <select class="form-control" name="id_situacao_seguro_desemprego">
            <option value="">Selecione uma opção</option>
            @foreach($situacoesSeguroDesemprego as $situacaoSeguroDesemprego)
                <option value="{{$situacaoSeguroDesemprego->id}}">{{$situacaoSeguroDesemprego->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="qtde_dias_vale_transporte">Quantidade de dias que recebe vale transporte *</label>
        <input type="text" class="form-control number-mask" value="" name="qtde_dias_vale_transporte"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="valor_vale_transporte">Valor de vale tranporte (R$) *</label>
        <input type="text" class="form-control money-mask" value="" name="valor_vale_transporte"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="valor_assistencia_medica">Valor de assistência médica (R$) *</label>
        <input type="text" class="form-control money-mask" value="" name="valor_assistencia_medica"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="desconto_assistencia_medica">Desconto de assistência médica (R$) *</label>
        <input type="text" class="form-control money-mask" value="" name="desconto_assistencia_medica"/>
    </div>
</div>

<div class="col-xs-6">
    <div class="checkbox check-primary checkbox-circle">
        <input type="checkbox" value="1" name="desconta_vale_transporte"
               id="desconta_vale_transporte">
        <label for="desconta_vale_transporte"> Desejo descontar o Vale Transporte do funcionário (6%)</label>
    </div>
</div>
<div class="col-xs-6">
    <div class="checkbox check-primary checkbox-circle">
        <input type="checkbox" value="1" name="experiencia" id="experiencia">
        <label for="experiencia"> O contrato é de experiência</label>
    </div>
</div>
<div class="col-xs-6">
    <div class="checkbox check-primary checkbox-circle">
        <input type="checkbox" value="1" name="professor" id="professor">
        <label for="professor"> Professor</label>
    </div>
</div>
<div class="col-xs-6">
    <div class="checkbox check-primary checkbox-circle">
        <input type="checkbox" value="1" name="primeiro_emprego" id="primeiro_emprego">
        <label for="primeiro_emprego"> Primeiro emprego</label>
    </div>
</div>
<div class="col-xs-12">
    <h3>Contrato de Experiência</h3>
    <hr>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="qtde_dias_experiencia">Quantidade de dias *</label>
        <input type="text" class="form-control number-mask" value="" name="qtde_dias_experiencia"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="data_inicio_experiencia">Data de início *</label>
        <input type="text" class="form-control date-mask" value="" name="data_inicio_experiencia"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="data_final_experiencia">Data de término *</label>
        <input type="text" class="form-control date-mask" value="" name="data_final_experiencia"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="data_inicio_prorrogacao_experiencia">Data de início de prorrogação *</label>
        <input type="text" class="form-control date-mask" value="" name="data_inicio_prorrogacao_experiencia"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="data_final_prorrogacao_experiencia">Data de término de prorrogação *</label>
        <input type="text" class="form-control date-mask" value="" name="data_final_prorrogacao_experiencia"/>
    </div>
</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar - Informações da empresa</button>
    <button class="btn btn-primary next">Avançar - Sócios <i class="fa fa-angle-right"></i></button>
</div>