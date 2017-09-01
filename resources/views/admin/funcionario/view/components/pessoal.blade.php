<div class='clearfix'></div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="nome_completo">Nome completo do funcionário *</label>
        <input type="text" class="form-control" name="nome_completo" value="{{$funcionario->nome_completo}}"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="nome_mae">Nome completo da mãe *</label>
        <input type="text" class="form-control" name="nome_mae" value="{{$funcionario->nome_mae}}"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="nome_pai">Nome completo do pai *</label>
        <input type="text" class="form-control" name="nome_pai" value="{{$funcionario->nome_pai}}"/>
    </div>
</div>
<div class="col-sm-6">
    <div class='form-group'>
        <label for="id_estado_civil">Estado civil *</label>
        <select name="id_estado_civil" class="form-control">
            <option value="">Selecione uma opção</option>
            @foreach($estadosCivis as $estadoCivil)
                <option {{$funcionario->id_estado_civil == $estadoCivil->id ? 'selected="selected"' : ''}} value="{{$estadoCivil->id}}">{{$estadoCivil->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-sm-4">
    <div class="form-group">
        <label for="data_nascimento">Data de nascimento *</label>
        <input type="text" class="form-control date-mask" value="{{$funcionario->data_nascimento->format('d/m/Y')}}" name="data_nascimento"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="nacionalidade">Nacionalidade *</label>
        <input type="text" class="form-control" value="{{$funcionario->nacionalidade}}" name="nacionalidade"/>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="nacionalidade">Naturalidade *</label>
        <input type="text" class="form-control" value="{{$funcionario->naturalidade}}" name="naturalidade"/>
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group">
        <label for="id_grau_instrucao">Grau de instrução *</label>
        <select class="form-control" name="id_grau_instrucao">
            <option value="">Selecione uma opção</option>
            @foreach($grausInstrucao as $grauInstrucao)
                <option {{$funcionario->id_grau_instrucao == $grauInstrucao->id ? 'selected="selected"' : ''}} value="{{$grauInstrucao->id}}">{{$grauInstrucao->descricao}}</option>
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
                <option {{$funcionario->id_grupo_sanguineo == $grupoSanguineo->id ? 'selected="selected"' : ''}} value="{{$grupoSanguineo->id}}">{{$grupoSanguineo->descricao}}</option>
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
                <option {{$funcionario->id_raca == $raca->id ? 'selected="selected"' : ''}} value="{{$raca->id}}">{{$raca->descricao}}</option>
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
                <option {{$funcionario->id_sexo == $sexo->id ? 'selected="selected"' : ''}} value="{{$sexo->id}}">{{$sexo->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="telefone">Telefone do funcionário *</label>
        <input type="text" class="form-control phone-mask" value="{{$funcionario->telefone}}" name="telefone"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label for="email">E-mail do funcionário</label>
        <input type="text" class="form-control" value="{{$funcionario->email}}" name="email"/>
    </div>
</div>
@if($funcionario->estrangeiro)
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
                    <option {{$funcionario->id_condicao_estrangeiro == $condicaoEstrangeiro->id ? 'selected="selected"' : ''}} value="{{$condicaoEstrangeiro->id}}">{{$condicaoEstrangeiro->descricao}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="data_chegada_estrangeiro">Data de chegada</label>
            <input type="text" class="form-control date-mask" name="data_chegada_estrangeiro" value="{{$funcionario->data_chegada_estrangeiro ? $funcionario->data_chegada_estrangeiro->format('d/m/Y') : ''}}"/>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="numero_processo_mte">Número do processo MTE</label>
            <input type="text" class="form-control" name="numero_processo_mte" value="{{$funcionario->numero_processo_mte}}"/>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="numero_rne">Número do RNE</label>
            <input type="text" class="form-control" name="numero_rne" value="{{$funcionario->numero_rne}}"/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="data_expedicao_rne">Data de expedição do RNE</label>
            <input type="text" class="form-control date-mask" name="data_expedicao_rne" value="{{$funcionario->data_expedicao_rne ? $funcionario->data_expedicao_rne->format('d/m/Y') : ''}}"/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="data_validade_rne">Data de validade do RNE</label>
            <input type="text" class="form-control date-mask" name="data_validade_rne" value="{{$funcionario->data_validade_rne ? $funcionario->data_validade_rne->format('d/m/Y') : ''}}"/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="validade_carteira_trabalho">Data de validade da CTPS</label>
            <input type="text" class="form-control date-mask" name="validade_carteira_trabalho" value="{{$funcionario->validade_carteira_trabalho->format('d/m/Y')}}"/>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group no-border">
            <label class="checkbox checkbox-styled radio-success">
                <input type="checkbox" value="1" name="casado_estrangeiro" id="casado_estrangeiro" {{$funcionario->casado_estrangeiro ? 'checked="checked"' : ''}}><span></span>
                Casado(a) com brasileiro(a)
            </label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group no-border">
            <label class="checkbox checkbox-styled radio-success">
                <input type="checkbox" value="1" name="filho_estrangeiro" id="filho_estrangeiro" {{$funcionario->filho_estrangeiro ? 'checked="checked"' : ''}}><span></span> Filho(s)
                com brasileiro(a)
            </label>
        </div>
    </div>
@endif
