<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class RecalculoValidation extends Validation
{
    protected static $rules = [
        'id_tipo_recalculo' => 'required',
        'descricao' => 'required',
    ];

    protected static $niceNames = [
        'id_tipo_recalculo' => 'Tipo', 'descricao' => 'Descrição'
    ];


}
