<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class ProcessoFolhaValidation extends Validation
{
    protected static $rules = [
        'id_empresa' => 'required',
        'inss' => 'required',
        'recibo_folha' => 'required',
        'competencia' => 'required'
    ];

    protected static $niceNames = [
        'recibo_folha' => 'Recibo da folha',
        'inss' => 'INSS',
        'irrf' => 'IRRF',
        'id_empresa' => 'Empresa',
        'competencia' => 'Competência'
    ];


}
