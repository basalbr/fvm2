<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class TipoAlteracaoValidation extends Validation
{
    protected static $rules = [
        'descricao' => 'required', 'valor'=>'required'
    ];

    protected static $niceNames = [
        'descricao' => 'Descrição','valor'=>'Valor'
    ];


}
