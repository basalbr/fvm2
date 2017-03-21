<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class ImpostoValidation extends Validation
{
    protected static $rules = [
        'nome' => 'required', 'vencimento' => 'required|integer', 'antecipa_posterga' => 'required', 'recebe_documento' => 'required'
    ];

    protected static $niceNames = [
        'nome' => 'Nome', 'vencimento' => 'Dia do Vencimento', 'antecipa_posterga' => 'Antecipa ou posterga', 'recebe_documento' => 'Receber documentos'
    ];


}
