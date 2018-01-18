<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class IrDependenteValidation extends Validation
{

    protected static $rules = [
        'id_tipo_dependente' => 'required',
        'nome' => 'required|max:191',
        'data_nascimento' => 'required|date_format:d/m/Y',
    ];

    protected static $niceNames = [
        'nome' => 'Nome Completo',
        'data_nascimento' => 'Data de Nascimento',
        'id_tipo_dependente' => 'Tipo de Dependente'
    ];


}
