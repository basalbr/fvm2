<!-- Cálculo de mensalidade -->
@include('dashboard.components.mensalidade.simulate')
@section('js')
    @parent
    <script type="text/javascript">
        $(function(){
            $("#" + $("#dsr").val() + " input").attr('disabled', 'disabled');
            $("#" + $("#dsr").val() + " td:nth-child(6) b").text('D.S.R');
            function msToTime(s) {
                function addZ(n) {
                    return (n < 10 ? '0' : '') + n;
                }
                var ms = s % 1000;
                s = (s - ms) / 1000;
                var secs = s % 60;
                s = (s - secs) / 60;
                var mins = s % 60;
                var hrs = (s - mins) / 60;
                if (!isNaN(addZ(hrs)) && !isNaN(addZ(mins))) {
                    return addZ(hrs) + ':' + addZ(mins);
                }
            }
            $("#dsr").on('change', function () {
                $("td input").each(function () {
                    if ($(this).attr('disabled')) {
                        $(this).removeAttr('disabled');
                        var id = $(this).parent().parent().attr('id');
                        $("#" + id + " td:nth-child(6) b").html('00:00');
                    }
                })
                $("#" + $("#dsr").val() + " input").val('').attr('disabled', 'disabled');
                $("#" + $("#dsr").val() + " td:nth-child(6) b").text('D.S.R');
            });
            $(".horario input").on('blur', function () {
                var id = $(this).parent().parent().attr('id');
                var horario1 = $("#" + id + " td:nth-child(2) input").val().split(":");
                var horario2 = $("#" + id + " td:nth-child(3) input").val().split(":");
                var horario3 = $("#" + id + " td:nth-child(4) input").val().split(":");
                var horario4 = $("#" + id + " td:nth-child(5) input").val().split(":");
                var data1 = new Date(2015, 1, 1, horario1[0], horario1[1]);
                var data2 = new Date(2015, 1, 1, horario2[0], horario2[1]);
                var data3 = new Date(2015, 1, 1, horario3[0], horario3[1]);
                var data4 = new Date(2015, 1, 1, horario4[0], horario4[1]);
                var resultado1 = false;
                var resultado2 = false;
                var resultadoFinal = "00:00";
                if (data1 > 0 && data2 > 0 && (data1 < data2)) {
                    resultado1 = data2 - data1;
                }
                if (data3 > 0 && data4 && (data3 < data4)) {
                    resultado2 = data4 - data3;
                }
                if (resultado1 > 0 && resultado2 > 0 && (data2 < data3)) {
                    resultadoFinal = resultado1 + resultado2;
                }
                if (!resultado1 && resultado2 > 0) {
                    resultadoFinal = resultado2;
                }
                if (resultado1 > 0 && !resultado2) {
                    resultadoFinal = resultado1;
                }
                if (msToTime(resultadoFinal)) {
                    $("#" + id + " td:nth-child(6) b").html(msToTime(resultadoFinal));
                }
            });
        });
    </script>
    @stop
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