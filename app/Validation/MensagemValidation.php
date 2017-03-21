<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class MensagemValidation extends Validation
{
    protected static $rules = [
        'mensagem' => 'required'
    ];

    protected static $niceNames = [
        'mensagem' => 'Mensagem'
    ];


}
