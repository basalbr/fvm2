<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class DecimoTerceiroValidation extends Validation
{
    protected static $rules = [
        'id_empresa' => 'required',
        'descricao' => 'required|max:191',
        'anexos' => 'array|min:1|required',
    ];

    protected static $niceNames = [
        'id_empresa' => 'Empresa',
        'descricao' => 'Descrição',
        'anexos' => 'Descrição do arquivo',
    ];
}
