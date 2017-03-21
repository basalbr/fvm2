<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class ChamadoValidation extends Validation
{
    protected static $rules = [
        'titulo' => 'required', 'mensagem' => 'required'
    ];

    protected static $niceNames = [
        'titulo' => 'Título', 'mensagem' => 'Mensagem'
    ];
}
