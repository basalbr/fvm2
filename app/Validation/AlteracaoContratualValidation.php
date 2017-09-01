<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class AlteracaoContratualValidation extends Validation
{
    protected static $rules = [
        'id_funcionario' => 'required', 'id_tipo_alteracao_contratual' => 'required', 'data_alteracao' => 'required|date_format:d/m/Y', 'motivo'=>'required', 'salario'=>'sometimes|required'
    ];

    protected static $niceNames = [
        'data_alteracao' => 'Data de alteração', 'id_tipo_alteracao_contratual' => 'Tipo de alteração', 'motivo'=>'Motivo', 'salario' => 'Salário'
    ];


}
