<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class TipoTributacaoValidation extends Validation
{
    protected static $rules = [
        'descricao' => 'required','has_tabela'=>'required|boolean'
    ];

    protected static $niceNames = [
        'descricao' => 'Descrição', 'has_tabela'=>'Precisa de Tabela do Simples Nacional'
    ];


}
