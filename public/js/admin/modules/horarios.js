$(function () {
    $("#" + $("#dsr").val() + " input").attr('disabled', 'disabled');
    $("#" + $("#dsr").val() + " .form-group").addClass('disabled');
    $("#" + $("#dsr").val() + " td:nth-child(6) b").text('D.S.R');

calculateHours();
    $("#dsr").on('change', function () {
calculateHours();
    });
    $(".horario input").on('blur', function () {
        calculateHours();
    });
});
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
function calculateHours() {
    $(".horario input").each(function () {
        if ($(this).attr('disabled')) {
            $(this).prop('disabled', false);
            $(this).parent().removeClass('disabled');
            var id = $(this).parent().parent().parent().attr('id');
            $("#" + id + " td:nth-child(6) b").html('00:00');
        }
    })
    $("#" + $("#dsr").val() + " input").val('').attr('disabled', 'disabled');
    $("#" + $("#dsr").val() + " .form-group").addClass('disabled');
    $("#" + $("#dsr").val() + " td:nth-child(6) b").text('D.S.R');
    $(".horario input").each(function () {

        var id = $(this).parent().parent().parent().attr('id');
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
        var resultadoAtual = $("#" + id + " td:nth-child(6) b").html();
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
        var hours = validateHoursOfWork();
        if (hours >= 0) {
            $('#total-horas strong').html(hours)
        } else {
            $("#" + id + " td:nth-child(6) b").html(resultadoAtual);
            $('#' + id + ' input').val(null);
            showModalAlert('O total de horas de trabalho não pode exceder 44 horas por semana');
        }
    })

}
function validateHoursOfWork() {
    var totalSeconds = 0;
    $("td:nth-child(6) b").each(function () {
        if ($(this).text() !== 'D.S.R') {
            totalSeconds += toSeconds($(this).text());
        }
    });
    var totalHours = Math.floor(totalSeconds / 3600);
    return totalHours <= 44 ? totalHours : -1;
}
function toSeconds(time) {
    var parts = time.split(':');
    return (+parts[0]) * 60 * 60 + (+parts[1]) * 60;
}