<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class AlteracaoInformacaoValidation extends Validation
{
    protected static $rules = [
        'valor' => 'required',
        'id_alteracao' => 'required',
        'id_alteracao_campo' => 'required'
    ];

    protected static $niceNames = [
        'descricao' => 'Descrição',
        'informacao' => 'Informação',
        'tipo' => 'Tipo'
    ];


}
