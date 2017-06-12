<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class FuncionarioDocumentoValidation extends Validation
{

    protected static $rules = [
        'nome' => 'required|max:191',
        'descricao' => 'required|max:191',
        'documento' => 'required|file|max:10240'
    ];

    protected static $niceNames = [
        'nome' => 'Tipo de documento',
        'descricao' => 'Descrição',
        'documento' => 'Documento'
    ];


}
