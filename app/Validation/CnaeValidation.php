<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class CnaeValidation extends Validation
{

    protected static $rules = [
        'descricao' => 'required', 'codigo' => 'required', 'id_tabela_simples_nacional' => 'required'
    ];

    protected static $niceNames = [
        'descricao' => 'Descrição', 'codigo' => 'Código', 'id_tabela_simples_nacional' => 'Tabela do simples nacional'
    ];


}
