<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class ProLaboreValidation extends Validation
{
    protected static $rules = [
        'pro_labore'=>'required', 'inss'=>'required','valor_pro_labore'=>'required'
    ];

    protected static $niceNames = [
        'pro_labore' => 'Pró-Labore', 'inss'=>'INSS','irrf'=>'IRRF', 'pro_labore_valo' => 'Valor do Pró-Labore'
    ];


}
