<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class ImpostoInformacaoExtraValidation extends Validation
{
    protected static $rules = [
        'id_informacao_extra' => 'required', 'extensao' => 'required'
    ];

    protected static $niceNames = [
        'extensao' => 'Extensão'
    ];


}
