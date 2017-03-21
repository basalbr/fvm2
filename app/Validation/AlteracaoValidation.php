<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class AlteracaoValidation extends Validation
{
    protected static $rules = [
        'id_pessoa' => 'required', 'id_tipo_alteracao' => 'required'
    ];

    protected static $niceNames = [
        'id_pessoa' => 'Empresa', 'id_tipo_alteracao' => 'Tipo de Alteração'
    ];


}
