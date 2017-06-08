<div class="col-sm-12">
    <h3>Contrato de Trabalho</h3>
    <hr>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="cargo">Cargo *</label>
        <input type="text" class="form-control" value="" name="cargo"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="funcao">Função *</label>
        <input type="text" class="form-control" value="" name="funcao"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="departamento">Departamento *</label>
        <input type="text" class="form-control" value="" name="departamento"/>
    </div>
</div>
<div class="col-sm-6">
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
<div class="col-sm-7">
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

<div class="col-sm-5">
    <div class="form-group">
        <label for="salario">Salário (R$) *</label>
        <input type="text" class="form-control money-mask" value="" name="salario"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="data_admissao">Data de admissão *</label>
        <input type="text" class="form-control date-mask" value="" name="data_admissao"/>
    </div>
</div>


{{--<div class="col-sm-8">--}}
{{--<div class="form-group">--}}
{{--<label for="id_situacao_seguro_desemprego">Situação do seguro desemprego *</label>--}}
{{--<select class="form-control" name="id_situacao_seguro_desemprego">--}}
{{--<option value="">Selecione uma opção</option>--}}
{{--@foreach($situacoesSeguroDesemprego as $situacaoSeguroDesemprego)--}}
{{--<option value="{{$situacaoSeguroDesemprego->id}}">{{$situacaoSeguroDesemprego->descricao}}</option>--}}
{{--@endforeach--}}
{{--</select>--}}
{{--</div>--}}
{{--</div>--}}
<div class="col-sm-7">
    <div class="form-group">
        <label for="vale_transporte">Recebe vale transporte? *</label>
        <select class="form-control" name="vale_transporte">
            <option value="">Selecione uma opção</option>
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
    </div>
</div>
<div class="col-sm-5">
    <div class="form-group">
        <label for="valor_vale_transporte">Valor de vale tranporte (R$)</label>
        <input type="text" class="form-control money-mask" value="" name="valor_vale_transporte"/>
    </div>
</div>
{{--<div class="col-sm-6">--}}
{{--<div class="form-group">--}}
{{--<label for="valor_assistencia_medica">Valor de assistência médica (R$)</label>--}}
{{--<input type="text" class="form-control money-mask" value="" name="valor_assistencia_medica"/>--}}
{{--</div>--}}
{{--</div>--}}
<div class="col-sm-6">
    <div class="form-group">
        <label for="desconto_assistencia_medica">Desconto de assistência médica (R$)</label>
        <input type="text" class="form-control money-mask" value="" name="desconto_assistencia_medica"/>
    </div>
</div>

<div class="col-sm-9">
    <div class="form-group no-border">
        <label class="checkbox checkbox-styled radio-success">
            <input type="checkbox" value="1" name="desconta_vale_transporte" id="desconta_vale_transporte"><span></span>
            Desejo descontar o Vale Transporte do funcionário (6%)
        </label>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-sm-3">
    <div class="form-group no-border">
        <label class="checkbox checkbox-styled radio-success">
            <input type="checkbox" value="1" name="professor" id="professor"><span></span> Professor
        </label>
        <div class="clearfix"></div>
    </div>
</div>


<div class="col-sm-6">
    <div class="form-group no-border">
        <label class="checkbox checkbox-styled radio-success">
            <input type="checkbox" value="1" name="primeiro_emprego" id="primeiro_emprego"><span></span> Primeiro
            emprego
        </label>
        <div class="clearfix"></div>
    </div>
</div>
<div id="contrato-experiencia" style="display: none;">
    <div class="col-sm-12">
        <h3>Contrato de Experiência</h3>
        <hr>
    </div>
    <div class="col-sm-12">
        <div class="form-group no-border">
            <label class="checkbox checkbox-styled radio-success">
                <input type="checkbox" value="1" name="experiencia" id="experiencia"><span></span> Desejo emitir o
                contrato de experiência
            </label>
            <div class="clearfix"></div>
        </div>
    </div>
    <div id="contrato-experiencia-info">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="qtde_dias_experiencia">Quantidade de dias *</label>
            <input type="text" class="form-control number-mask" value="" name="qtde_dias_experiencia"/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group disabled">
            <label for="data_inicio_experiencia">Data de início</label>
            <input type="text" class="form-control date-mask" disabled="disabled" value="" id="data_inicio_experiencia"/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group disabled">
            <label for="data_final_experiencia">Data de término</label>
            <input type="text" class="form-control date-mask" disabled="disabled" value=""/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="qtde_dias_prorrogacao_experiencia">Quantidade de dias de prorrogação</label>
            <input type="text" class="form-control number-mask" value="" name="qtde_dias_prorrogacao_experiencia"/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group disabled">
            <label for="data_inicio_prorrogacao_experiencia">Data de início</label>
            <input type="text" class="form-control date-mask" disabled="disabled" value=""/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group disabled">
            <label for="data_final_prorrogacao_experiencia">Data de término</label>
            <input type="text" class="form-control date-mask" disabled="disabled" value=""/>
        </div>
    </div>
    </div>
</div>
<div class="col-sm-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar - Informações da empresa</button>
    <button class="btn btn-primary next">Avançar - Sócios <i class="fa fa-angle-right"></i></button>
</div>