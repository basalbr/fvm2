<!-- Cálculo de mensalidade -->
@include('dashboard.components.mensalidade.simulate')

<div class="col-xs-12">
    <h3>Horários de trabalho</h3>
    <hr>
</div>
<div class="col-xs-12">
    <p>Digite na tabela abaixo o horário de trabalho do funcionário de acordo com o dia da semana.</p>

    <table class='table table-hover table-bordered table-striped'>
        <thead>
        <tr>
            <th></th>
            <th colspan="2" class="bg-primary">1° TURNO</th>
            <th colspan="2" class="bg-primary">2° TURNO</th>
            <th></th>
        </tr>
        <tr>
            <th style=" min-width: 78px;">Dia</th>
            <th>Entrada</th>
            <th>Saída</th>
            <th>Entrada</th>
            <th>Saída</th>
            <th>Total de horas</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dow as $n => $dia)
            <tr id="{{$n}}">
                <td style="vertical-align: middle; min-width: 78px;"><b>{{$dia}}</b></td>
                <td class="text-center horario">
                    <input class="form-control time-mask" type="text" name="horario[{{$n}}][0]" value="">
                </td>
                <td class="text-center horario">
                    <input class="form-control time-mask" type="text" name="horario[{{$n}}][1]" value="">
                </td>
                <td class="text-center horario">
                    <input class="form-control time-mask" type="text" name="horario[{{$n}}][2]" value="">
                </td>
                <td class="text-center horario">
                    <input class="form-control time-mask" type="text" name="horario[{{$n}}][3]" value="">
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <b>00:00</b>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar - CNAEs</button>
    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Finalizar e Pagar
    </button>
</div>