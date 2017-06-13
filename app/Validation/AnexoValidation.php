<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class AnexoValidation extends Validation
{
    protected static $rules = [
        'arquivo' => 'required|file|max:10240',
        'descricao' => 'required|max:191'
    ];

    protected static $niceNames = [
        'arquivo' => 'Arquivo',
        'descricao' => 'Descrição'
    ];
}
