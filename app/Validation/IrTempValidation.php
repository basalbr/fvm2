<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class IrTempValidation extends Validation
{

    protected static $rules = [
        'nome' => 'required|max:191',
    ];

    protected static $niceNames = [
        'nome' => 'Nome Completo',
    ];


}
