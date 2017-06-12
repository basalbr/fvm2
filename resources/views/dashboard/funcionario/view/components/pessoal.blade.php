@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('[name="contrato[qtde_dias_experiencia]"], [name="contrato[qtde_dias_prorrogacao_experiencia]"]').on('keyup', function () {
                $('#data_inicio_experiencia').val($('[name="contrato[data_admissao]"]').val());
                var days = parseInt($('[name="contrato[qtde_dias_experiencia]"]').val()) + parseInt($('[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val());
                if (days > 90) {
                    showModalAlert('A quantidade de dias de experiência não pode exceder 90.');
                    $('#contrato-experiencia-info input').val(null);
                } else {
                    calculateDaysOfExperience();
                }
            });
            $('#experiencia').on('change', function () {
                if ($(this).is(':checked')) {
                    $("#contrato-experiencia-info").show().find('[name="contrato[qtde_dias_experiencia]"],[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val(45).prop('disabled', false);
                    calculateDaysOfExperience();
                } else {
                    $("#contrato-experiencia-info").hide().find('[name="contrato[qtde_dias_experiencia]"],[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val(null).prop('disabled', true);
                }
            });
            $('[name="contrato[sindicalizado]"]').on('change', function () {
                if ($(this).val() === '1') {
                    $('#info-sindicato').show().find('input').prop('disabled', false);
                } else {
                    $('#info-sindicato').hide().find('input').prop('disabled', true).val(null);
                }
            });
            $('#tipo-cadastro').on('change', function () {
                $('#contrato-experiencia input[type="checkbox"]').prop('checked', false);
                $("#contrato-experiencia-info").hide().find('[name="contrato[qtde_dias_experiencia]"],[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val(null).prop('disabled', true);
                if ($(this).val() == 1) {
                    $("#exame-admissional").show();
                    $("#exame-admissional input").prop('disabled', false);
                    $("#contrato-experiencia").show();
                    $("#contrato-experiencia input[type='checkbox']").prop('disabled', false);

                } else {
                    $("#exame-admissional").hide();
                    $("#exame-admissional input").prop('disabled', true);
                    $("#contrato-experiencia").hide();
                    $("#contrato-experiencia input").prop('disabled', true);
                }
            });
            $('#estrangeiro').on('change', function () {
                if ($(this).val() == 1) {
                    $("#info-estrangeiro").show();
                    $("#info-estrangeiro input").prop('disabled', false)
                } else {
                    $("#info-estrangeiro").hide();
                    $("#info-estrangeiro input").prop('disabled', true)
                }
            });
            $('[name="contrato[data_admissao]"]').on('keyup', function () {
                $('#data_inicio_experiencia').val($(this).val());
                if ($(this).val().length == 10) {
                    if (isValidDate($(this).val())) {
                        calculateDaysOfExperience();
                    } else {
                        $(this).val(null);
                        $('#contrato-experiencia-info input').val(null);
                        showModalAlert('A data de admissão deve ser uma data válida, por exemplo: 01/01/2017')
                    }
                }
            });
        });
        function calculateDaysOfExperience() {

            if ($('#experiencia').is(':checked') && $('[name="contrato[data_admissao]"]').val().length == 10) {
                if (isValidDate($('[name="contrato[data_admissao]"]').val())) {
                    var dataInicioExperiencia = parseStringToDate($('#data_inicio_experiencia').val());
                    var qtdeDiasExperiencia = $('[name="contrato[qtde_dias_experiencia]"]').val() !== '' ? parseInt($('[name="contrato[qtde_dias_experiencia]"]').val()) : 0;
                    var qtdeDiasProrrogacao = $('[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val() !== '' ? parseInt($('[name="contrato[qtde_dias_prorrogacao_experiencia]"]').val()) : 0;
                    $('#data_final_experiencia').val(parseDateToString(addDaysToDate(dataInicioExperiencia, qtdeDiasExperiencia)));
                    var dataFinalExperiencia = parseStringToDate($('#data_final_experiencia').val());
                    $('#data_inicio_prorrogacao').val(parseDateToString(addDaysToDate(dataFinalExperiencia, 1)));
                    var dataInicioProrrogacao = parseStringToDate($('#data_inicio_prorrogacao').val());
                    $('#data_final_prorrogacao').val(parseDateToString(addDaysToDate(dataInicioProrrogacao, qtdeDiasProrrogacao)));
                }
            }

        }
        function parseStringToDate(string) {
            try {
                var dsplit = string.split("/");
                return new Date(dsplit[2], dsplit[1] - 1, dsplit[0]);
            } catch (e) {
                throw (new Error('Formato de data inválido'));
            }
        }
        function addDaysToDate(date, days) {
            try {
                return new Date(date.setDate(date.getDate() + days));
            } catch (e) {
                throw (new Error('Formato de data inválido'));
            }
        }
        function parseDateToString(date) {

            var month = (date.getMonth() + 1) < 10 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
            var day = date.getDate() < 10 ? "0" + date.getDate().toString() : date.getDate().toString();
            return day + '/' + month + '/' + date.getFullYear().toString();
        }
        function isValidDate(s) {
            var bits = s.split('/');
            var d = new Date(bits[2], bits[1] - 1, bits[0]);
            return d && (d.getMonth() + 1) == bits[1];
        }
    </script>
@stop

<div class="col-xs-12">
    <h3>Informações pessoais</h3>
    <hr>
</div>
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
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-primary next">Avançar - Endereço <span class="fa fa-angle-right"></span>
    </button>
</div>