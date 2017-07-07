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
        'pro_labore'=>'required', 'inss'=>'required','valor_pro_labore'=>'required', 'competencia'=>'required'
    ];

    protected static $niceNames = [
        'pro_labore' => 'Guia do Pró-Labore', 'inss'=>'Guia do INSS','irrf'=>'Guia do IRRF', 'valor_pro_labore' => 'Valor do Pró-Labore', 'competencia'=>'Competência'
    ];


}
