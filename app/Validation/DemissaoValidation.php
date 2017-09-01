<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class DemissaoValidation extends Validation
{
    protected static $rules = [
        'id_funcionario' => 'required', 'id_tipo_demissao' => 'required', 'id_tipo_aviso_previo' => 'required', 'data_demissao' => 'date_format:d/m/Y'
    ];

    protected static $niceNames = [
        'id_tipo_demissão' => 'Tipo de demissão', 'id_tipo_aviso_previo' => 'Tipo de aviso prévio', 'data_demissao' => 'Data de demissão'
    ];


}
