<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class ProcessoValidation extends Validation
{
    protected static $rules = [
        'id_pessoa' => 'required', 'competencia' => 'required', 'id_imposto' => 'required', 'vencimento' => 'required|date'
    ];

    protected static $niceNames = [
        'competencia' => 'Competência'
    ];
}
