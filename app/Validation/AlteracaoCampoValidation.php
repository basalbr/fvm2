<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class AlteracaoCampoValidation extends Validation
{

    protected static $rules = [
        'tipo' => 'required',
        'nome' => 'required',
        'descricao' => 'required'
    ];

    protected static $niceNames = [
        'nome' => 'Nome',
        'descricao' => 'Descrição',
        'tipo' => 'Tipo'
    ];


}
