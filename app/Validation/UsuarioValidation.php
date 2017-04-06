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
        'nome' => 'required',
        'email' => 'required|unique:usuario,email|email',
        'telefone' => 'required|min:13|max:16',
        'senha' => 'required|confirmed',
        'senha_confirmed' => 'sometimes|required'
    ];

    protected static $niceNames = [
        'nome' => 'Nome completo',
        'email' => 'E-mail',
        'senha' => 'Senha',
        'senha_confirmed' => 'Confirmar sua senha',
        'telefone' => 'Telefone ou celular'
    ];


}
