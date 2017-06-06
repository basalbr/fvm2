<div class="col-xs-12">
    <h3>Informações pessoais</h3>
    <hr>
</div>
<div class='col-xs-12'>
    <div class="form-group">
        <label class="control-label">Tipo de Cadastro</label>
        <select name="novo_funcionario" class="form-control" id="tipo-cadastro">
            <option value="1">Novo funcionário
                na empresa
            </option>
            <option value="0">O funcionário já
                se encontra no quadro da empresa
            </option>
        </select>
    </div>
</div>
<div class='clearfix'></div>
<br/>
<div id='exame-admissional' style="display: none">
    <h3 class="text-uppercase">Exame admissional</h3>
    <div class='col-xs-12'>
        <label class="control-label">Anexe um arquivo contendo o exame admissional</label>
        <input class="form-control" type="file" placeholder="Clique para anexar o exame admissional"
               name="exame_admissional" disabled="">
    </div>
    <div class='clearfix'></div>
    <br/>
    <br/>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="nome_completo">Nome completo *</label>
        <input type="text" class="form-control" name="nome_completo" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="nome_mae">Nome completo da mãe *</label>
        <input type="text" class="form-control" name="nome_mae" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="nome_pai">Nome completo do pai *</label>
        <input type="text" class="form-control" name="nome_pai" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="nome_conjuge">Nome completo do cônjuge (se for casado)</label>
        <input type="text" class="form-control" name="nome_conjuge" value=""/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="data_nascimento">Data de nascimento *</label>
        <input type="text" class="form-control date-mask" value="" name="data_nascimento"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="nacionalidade">Nacionalidade *</label>
        <input type="text" class="form-control" value="" name="nacionalidade"/>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="nacionalidade">Naturalidade *</label>
        <input type="text" class="form-control" value="" name="naturalidade"/>
    </div>
</div>

<div class="col-xs-6">
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
<div class="col-xs-6">
    <div class="form-group">
        <label for="id_grupo_sanguineo">Grupo sanguíneo *</label>
        <select class="form-control" name="id_grupo_sanguineo">
            <option value="">Selecione uma opção</option>
            @foreach($gruposSanguineos as $grupoSanguineo)
                <option value="{{$grupoSanguineo->id}}">{{$grupoSanguineo->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-6">
    <div class="form-group">
        <label for="id_raca">Raça/Cor *</label>
        <select class="form-control" name="id_raca">
            <option value="">Selecione uma opção</option>
            @foreach($racas as $raca)
                <option value="{{$raca->id}}">{{$raca->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-xs-6">
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
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-primary next">Avançar - Documentos <span class="fa fa-angle-right"></span>
    </button>
</div>