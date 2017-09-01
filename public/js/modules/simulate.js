var qtdeFuncionarios, qtdeProLabores, qtdeDocsContabeis, qtdeDocsFiscais, minPrice, maxPrice,
    maxDocsFiscais, maxDocsContabeis, maxProLabores, planos;

$(function () {
    //Busca no banco de dados as opcoes de pagamento
    $.get($('#payment-parameters').val()).done(function (data, textStatus, jqXHR) {
        planos = data.planos;
        maxDocsFiscais = parseInt(data.maxDocsFiscais);
        maxPrice = parseFloat(data.maxPrice);
        gatherDataAndSimulate();

    }).fail(function (jqXHR, textStatus, errorThrown) {
    });

    $('[name*="qtde_funcionario"]').val(0);
    $('[name*="qtde_documento_fiscal"]').val(10);
    $('#contabilidade').val('499,99')
    $('#contabilidade, [name*="qtde_funcionario"], [name*="qtde_pro_labores"],[name*="qtde_documento_contabil"],[name*="qtde_documento_fiscal"]').on('blur, focus, keyup', function () {
        gatherDataAndSimulate();
    });
});

function gatherDataAndSimulate() {
    $('#modal-simulate .modal-body').empty();
    qtdeFuncionarios = isNaN(parseInt($('[name*="qtde_funcionario"]').val())) ? 0 : $('[name*="qtde_funcionario"]').val();
    qtdeDocsFiscais = isNaN(parseInt($('[name*="qtde_documento_fiscal"]').val())) ? 0 : $('[name*="qtde_documento_fiscal"]').val();

    simulateMonthlyPayment(qtdeFuncionarios, qtdeDocsFiscais);
}

function simulateMonthlyPayment(qtdeFuncionarios, qtdeDocFiscais) {
    var acrescimoFuncionarios = 0;
    minPrice = maxPrice;
    if (qtdeDocFiscais > maxDocsFiscais) {
        $('[name*="qtde_documento_fiscal"]').val(maxDocsFiscais);
    }
    if (qtdeFuncionarios >= 10) {
        acrescimoFuncionarios = qtdeFuncionarios * 20;
    } else {
        acrescimoFuncionarios = qtdeFuncionarios * 25;
    }
    for (var i in planos) {
        if (qtdeDocFiscais <= parseInt(planos[i].total_documento_fiscal)
            && parseFloat(planos[i].valor) < minPrice) {
            minPrice = parseFloat(planos[i].valor);
        }
    }
    minPrice = parseFloat(minPrice + acrescimoFuncionarios).toFixed(2);
    var contabilidade = $('#contabilidade').val().replace(".", "");
    contabilidade = parseFloat(contabilidade.replace(",", "."));
    var totalDesconto = (contabilidade * 12) - (minPrice * 12) > 0 ? (contabilidade * 12) - (minPrice * 12) : 0;
    minPrice = minPrice.replace(".", ",");
    totalDesconto = totalDesconto.toFixed(2).replace(".", ",");
    $('#valor-mensalidade span').text(minPrice);
    $('#valor-economia span').text(totalDesconto);
    $('#modal-simulate .modal-body').html($('#mensalidade-box').html())
}