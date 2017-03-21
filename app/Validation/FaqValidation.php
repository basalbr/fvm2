<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class FaqValidation extends Validation
{
    protected static $rules = [
        'local' => 'required','pergunta'=>'required','resposta'=>'required'
    ];

    protected static $niceNames = [
        'local' => 'Local', 'pergunta'=>'Pergunta','resposta'=>'Resposta'
    ];


}
