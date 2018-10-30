<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class BalanceteValidation extends Validation
{

    protected static $rules = [
        'id_empresa' => 'required',
        'exercicio' => 'required|date_format:d/m/Y',
        'receitas' => 'required',
        'despesas' => 'required',
        'anexo' => 'file|required',
    ];

    protected static $niceNames = [
        'id_empresa' => 'Empresa',
        'exercicio' => 'Exercício',
        'receitas' => 'Receitas',
        'despesas' => 'Despesas',
        'anexo' => 'Balancete',
    ];


}
