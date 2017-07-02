var qtdeFuncionarios, qtdeProLabores, qtdeDocsContabeis, qtdeDocsFiscais, minPrice, maxPrice,
    maxDocsFiscais, maxDocsContabeis, maxProLabores, planos;

$(function () {
    //Busca no banco de dados as opcoes de pagamento
    $.get($('#payment-parameters').val()).done(function (data, textStatus, jqXHR) {
        planos = data.planos;
        maxDocsFiscais = parseInt(data.maxDocsFiscais);
        maxDocsContabeis = parseInt(data.maxDocsContabeis);
        maxProLabores = parseInt(data.maxProLabores);
        maxPrice = parseFloat(data.maxPrice);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR, textStatus, errorThrown);
    });

    $('#modal-socio').on('hide.bs.modal', function (e) {
        gatherDataAndSimulate();
    });

    $('[name*="qtde_funcionario"], [name*="qtde_pro_labores"],[name*="qtde_documento_contabil"],[name*="qtde_documento_fiscal"]').on('blur, focus, keyup', function () {
        gatherDataAndSimulate();
    });
});

function gatherDataAndSimulate() {
    qtdeFuncionarios = isNaN(parseInt($('[name*="qtde_funcionario"]').val())) ? 0 : $('[name*="qtde_funcionario"]').val();
    qtdeProLabores = 0;
    $("[name*='pro_labore']").each(function () {
        if (isNaN($(this).val())) {
            qtdeProLabores++;
        }
    });
    qtdeDocsContabeis = isNaN(parseInt($('[name*="qtde_documento_contabil"]').val())) ? 0 : $('[name*="qtde_documento_contabil"]').val();
    qtdeDocsFiscais = isNaN(parseInt($('[name*="qtde_documento_fiscal"]').val())) ? 0 : $('[name*="qtde_documento_fiscal"]').val();

    simulateMonthlyPayment(qtdeFuncionarios, qtdeProLabores, qtdeDocsContabeis, qtdeDocsFiscais);
    $('#qtde-funcionarios').text(qtdeFuncionarios);
    $('#qtde-pro-labores').text(qtdeProLabores);
    $('#qtde-documentos-contabeis').text(qtdeDocsContabeis);
    $('#qtde-documentos-fiscais').text(qtdeDocsFiscais);
}

function simulateMonthlyPayment(qtdeFuncionarios, qtdeProLabores, qtdeDocContabeis, qtdeDocFiscais) {
    var acrescimoFuncionarios = 0;
    minPrice = maxPrice;
    if (qtdeDocFiscais > maxDocsFiscais) {
        $('[name*="qtde_documento_fiscal"]').val(maxDocsFiscais);
    }
    if (qtdeDocsContabeis > maxDocsContabeis) {
        $('[name*="qtde_documento_contabil"]').val(maxDocsContabeis);
    }
    if (qtdeFuncionarios >= 10) {
        acrescimoFuncionarios = qtdeFuncionarios * 20;
    } else {
        acrescimoFuncionarios = qtdeFuncionarios * 25;
    }
    for (var i in planos) {
        if (qtdeDocContabeis <= parseInt(planos[i].total_documento_contabil)
            && qtdeDocFiscais <= parseInt(planos[i].total_documento_fiscal)
            && qtdeProLabores <= parseInt(planos[i].total_pro_labore)
            && parseFloat(planos[i].valor) < minPrice) {

            minPrice = parseFloat(planos[i].valor);

        }
    }
    minPrice = parseFloat(minPrice + acrescimoFuncionarios).toFixed(2);
    minPrice = minPrice.replace(".", ",");
    $('#mensalidade').text('R$' + minPrice);
}