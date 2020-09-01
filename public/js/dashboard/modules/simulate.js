var qtdeFuncionarios, qtdeProLabores, qtdeDocsContabeis, qtdeDocsFiscais, minPrice, maxPrice,
    maxDocsFiscais, maxDocsContabeis, maxProLabores, planos, isComercio, isIndustria, isServico,
    valorAberturaServico, valorAberturaComercio, valorAberturaIndustria, valorAbertura, sn_lp;

$(function () {
    //Busca no banco de dados as opcoes de pagamento
    $.get($('#payment-parameters').val()).done(function (data, textStatus, jqXHR) {
        planos = data.planos;
        maxDocsFiscais = parseInt(data.maxDocsFiscais);
        maxPrice = parseFloat(data.maxPrice);
        valorAberturaServico = data.valorAberturaServico;
        valorAberturaComercio = data.valorAberturaComercio;
        valorAberturaIndustria = data.valorAberturaIndustria;
        valorAbertura = data.valorAbertura;
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR, textStatus, errorThrown);
    });

    $('#modal-socio').on('hide.bs.modal', function (e) {
        gatherDataAndSimulate();
    });

    $('.is-industria-checkbox,.is-comercio-checkbox,.is-servico-checkbox').on('change', function () {
        gatherDataAndSimulate();
    });

    $('[name*="qtde_funcionario"], [name*="qtde_pro_labores"],[name*="qtde_documento_contabil"],[name*="qtde_documento_fiscal"]').on('blur, focus, keyup', function () {
        gatherDataAndSimulate();
    });
    $('[name*="id_tipo_tributacao"]').on('blur, focus, keyup, change', function () {
        gatherDataAndSimulate();
    });
});

function gatherDataAndSimulate() {
    qtdeFuncionarios = isNaN(parseInt($('[name*="qtde_funcionario"]').val())) ? 0 : $('[name*="qtde_funcionario"]').val();
    qtdeDocsFiscais = isNaN(parseInt($('[name*="qtde_documento_fiscal"]').val())) ? 0 : $('[name*="qtde_documento_fiscal"]').val();
    isServico = $('[name*="is_servico"]').prop('checked') ? true : false;
    isComercio = $('[name*="is_comercio"]').prop('checked') ? true : false;
    isIndustria = $('[name*="is_industria"]').prop('checked') ? true : false;

    simulateMonthlyPayment(qtdeFuncionarios, qtdeDocsFiscais);
    $('#qtde-funcionarios').text(qtdeFuncionarios);
    $('#qtde-documentos-fiscais').text(qtdeDocsFiscais);
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
    $('#regime_lp').prop('checked') == true || parseInt($('[name="id_tipo_tributacao"] :selected').val()) == 3 ? sn_lp = 200 : sn_lp = 0;
    minPrice += sn_lp;
    if (isComercio || isIndustria) {
        $('.abertura-price').text('R$' + parseFloat(valorAbertura + valorAberturaComercio).toFixed(2).replace(".", ","));
    }else{
        $('.abertura-price').text('R$' + parseFloat(valorAbertura).toFixed(2).replace(".", ","));
    }
    minPrice = parseFloat(minPrice + acrescimoFuncionarios).toFixed(2);
    minPrice = minPrice.replace(".", ",");
    $('#mensalidade, .mensalidade_contrato').text('R$' + minPrice);
}