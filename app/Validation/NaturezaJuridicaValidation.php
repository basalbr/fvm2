<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class NaturezaJuridicaValidation extends Validation
{

    protected static $rules = [
        'descricao' => 'required','representante'=>'required','qualificacao'=>'required','codigo'=>'required'
    ];

    protected static $niceNames = [
        'descricao' => 'Descrição', 'representante'=>'Representante','qualificacao'=>'Qualificação','codigo'=>'Código'
    ];


}
