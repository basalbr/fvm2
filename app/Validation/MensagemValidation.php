<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

/**
 * Class MensagemValidation
 * @package App\Validation
 */
class MensagemValidation extends Validation
{
    protected static $rules = [
        'mensagem' => 'required',
        'id_usuario' => 'required',
        'id_referencia' => 'required',
        'from_admin' => 'boolean',
        'referencia' => 'required'
    ];

    protected static $niceNames = [
        'mensagem' => 'Mensagem',
        'id_usuario' => 'Usuário',
        'id_referencia' => 'ID de referência',
        'from_admin' => 'Administrador',
        'referencia' => 'Referência'
    ];


}
