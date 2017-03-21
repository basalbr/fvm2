<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class UsuarioValidation extends Validation
{
    protected static $rules = [
        'nome' => 'required', 'email' => 'required|unique:usuario,email', 'senha' => 'required|confirmed'
    ];

    protected static $niceNames = [
        'nome' => 'Nome', 'email' => 'E-mail', 'senha' => 'Senha', 'senha_confirmed' => 'Confirmar Senha'
    ];


}
