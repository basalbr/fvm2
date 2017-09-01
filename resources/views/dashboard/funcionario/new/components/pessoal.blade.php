<div class="col-xs-12">
    <h3>Informações pessoais</h3>
    <hr>
</div>
<div class='clearfix'></div>
<div class='col-xs-12'>
    <div class="form-group">
        <label class="control-label">Tipo de Cadastro</label>
        <select name="novo_funcionario" class="form-control" id="tipo-cadastro">
            <option value="1">Novo funcionário
                na empresa
            </option>
            <option value="0" selected>O funcionário já
                se encontra no quadro da empresa
            </option>
        </select>
    </div>
</div>
<div class='clearfix'></div>
<div id='exame-admissional' style="display: none">
    <div class='col-xs-12'>
        <div class="form-group">

            <label class="control-label">Anexe o exame admissional</label>
            <input class="form-control" type="file" placeholder="Clique para anexar o exame admissional"
                   name="documentos[exame_admissional]" disabled="">
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="nome_completo">Nome completo do funcionário *</label>
        <input type="text" class="form-control" name="nome_completo" value=""/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="nome_mae">Nome completo da mãe *</label>
        <input type="text" class="form-control" name="nome_mae" value=""/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="nome_pai">Nome completo do pai *</label>
        <input type="text" class="form-control" name="nome_pai" value=""/>
    </div>
</div>
<div class="col-sm-6">
    <div class='form-group'>
        <label for="id_estado_civil">Estado civil *</label>
        <select name="id_estado_civil" class="form-control">
            <option value="">Selecione uma opção</option>
            @foreach($estadosCivis as $estadoCivil)
                <option value="{{$estadoCivil->id}}">{{$estadoCivil->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-sm-4">
    <div class="form-group">
        <label for="data_nascimento">Data de nascimento *</label>
        <input type="text" class="form-control date-mask" value="" name="data_nascimento"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="nacionalidade">Nacionalidade *</label>
        <input type="text" class="form-control" value="" name="nacionalidade"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="nacionalidade">Naturalidade *</label>
        <input type="text" class="form-control" value="" name="naturalidade"/>
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group">
        <label for="id_grau_instrucao">Grau de instrução *</label>
        <select class="form-control" name="id_grau_instrucao">
            <option value="">Selecione uma opção</option>
            @foreach($grausInstrucao as $grauInstrucao)
                <option value="{{$grauInstrucao->id}}">{{$grauInstrucao->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="id_grupo_sanguineo">Grupo sanguíneo</label>
        <select class="form-control" name="id_grupo_sanguineo">
            <option value="">Não informado</option>
            @foreach($gruposSanguineos as $grupoSanguineo)
                <option value="{{$grupoSanguineo->id}}">{{$grupoSanguineo->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="id_raca">Raça/Cor</label>
        <select class="form-control" name="id_raca">
            <option value="">Não informado</option>
            @foreach($racas as $raca)
                <option value="{{$raca->id}}">{{$raca->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="id_sexo">Sexo *</label>
        <select class="form-control" name="id_sexo">
            <option value="">Selecione uma opção</option>
            @foreach($sexos as $sexo)
                <option value="{{$sexo->id}}">{{$sexo->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="telefone">Telefone do funcionário *</label>
        <input type="text" class="form-control phone-mask" value="" name="telefone"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="email">E-mail do funcionário</label>
        <input type="text" class="form-control" value="" name="email"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="estrangeiro">É estrangeiro? *</label>
        <select class="form-control" id="estrangeiro" name="estrangeiro">
            <option value="0">Não</option>
            <option value="1">Sim</option>
        </select>
    </div>
</div>
<div id="info-estrangeiro" style="display: none;">
    <div class="col-xs-12">
        <h3>Estrangeiro</h3>
        <hr>
    </div>
    <div class="col-sm-8">
        <div class="form-group">
            <label for="id_condicao_estrangeiro">Condição *</label>
            <select class="form-control" name="id_condicao_estrangeiro">
                <option value="">Selecione uma opção</option>
                @foreach($condicoesEstrangeiro as $condicaoEstrangeiro)
                    <option value="{{$condicaoEstrangeiro->id}}">{{$condicaoEstrangeiro->descricao}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="data_chegada_estrangeiro">Data de chegada</label>
            <input type="text" class="form-control date-mask" name="data_chegada_estrangeiro" value=""/>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="numero_processo_mte">Número do processo MTE</label>
            <input type="text" class="form-control" name="numero_processo_mte" value=""/>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="numero_rne">Número do RNE</label>
            <input type="text" class="form-control" name="numero_rne" value=""/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="data_expedicao_rne">Data de expedição do RNE</label>
            <input type="text" class="form-control date-mask" name="data_expedicao_rne" value=""/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="data_validade_rne">Data de validade do RNE</label>
            <input type="text" class="form-control date-mask" name="data_validade_rne" value=""/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="validade_carteira_trabalho">Data de validade da CTPS</label>
            <input type="text" class="form-control date-mask" name="validade_carteira_trabalho" value=""/>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group no-border">
            <label class="checkbox checkbox-styled radio-success">
                <input type="checkbox" value="1" name="casado_estrangeiro" id="casado_estrangeiro"><span></span>
                Casado(a) com brasileiro(a)
            </label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group no-border">
            <label class="checkbox checkbox-styled radio-success">
                <input type="checkbox" value="1" name="filho_estrangeiro" id="filho_estrangeiro"><span></span> Filho(s)
                com brasileiro(a)
            </label>
        </div>
    </div>
</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-primary next">Avançar <span class="fa fa-angle-right"></span>
    </button>
</div>