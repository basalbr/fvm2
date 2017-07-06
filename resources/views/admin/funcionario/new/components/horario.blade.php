<div class="col-xs-12">
    <h3>Horários de trabalho</h3>
    <hr>
</div>
<div class="col-xs-12">
    <p>Escolha o dia do descanso semanal remunerado (D.S.R)</p>

    <div class="form-group">
        <label for="id_grau_instrucao">D.S.R *</label>
        <select class="form-control" id='dsr' name='contrato[dsr]'>
            @foreach($dow as $n => $dia)
                <option value="{{$n}}" {{$n == 0 ? 'selected="selected"' : ''}}>{{$dia}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-12">
    <p>Digite na tabela abaixo o horário de trabalho do funcionário de acordo com o dia da semana.</p>

    <div class="form-group no-border">
        <label class="checkbox checkbox-styled radio-success">
            <input type="checkbox" value="1" name="contrato[banco_horas]" id="banco_horas"><span></span> Possui banco de horas
        </label>
        <div class="clearfix"></div>
    </div>
</div>
@include('dashboard.components.horario.new')
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar - CNAEs</button>
    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Finalizar e Pagar
    </button>
</div>